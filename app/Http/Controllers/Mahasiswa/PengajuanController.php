<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\PengajuanSurat;
use App\Models\DokumenPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    public function index(Request $request)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        $query = PengajuanSurat::with('jenisSurat')
            ->where('mahasiswa_id', $mahasiswa->id);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis_surat_id')) {
            $query->where('jenis_surat_id', $request->jenis_surat_id);
        }

        if ($request->filled('search')) {
            $query->where('nomor_pengajuan', 'like', '%' . $request->search . '%');
        }

        $pengajuans = $query->latest()->paginate(10)->withQueryString();

        $jenisSurats = JenisSurat::where('status', 'aktif')
            ->orderBy('nama_surat')
            ->get();

        return view('mahasiswa.pengajuan.index', compact('pengajuans', 'jenisSurats'));
    }

    public function create()
    {
        $jenisSurats = JenisSurat::where('status', 'aktif')
            ->orderBy('nama_surat')
            ->get();

        $mahasiswa = Auth::user()->mahasiswa;

        return view('mahasiswa.pengajuan.create', compact('jenisSurats', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surats,id',
            'keperluan'      => 'required|string|min:10|max:500',
            'dokumen'        => 'nullable|array',
            'dokumen.*'      => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'jenis_surat_id.required' => 'Pilih jenis surat terlebih dahulu.',
            'keperluan.required'      => 'Keperluan pengajuan wajib diisi.',
            'keperluan.min'           => 'Keperluan minimal 10 karakter.',
            'dokumen.*.mimes'         => 'Dokumen harus berupa PDF, JPG, atau PNG.',
            'dokumen.*.max'           => 'Ukuran dokumen maksimal 2MB.',
        ]);

        DB::beginTransaction();

        try {
            $mahasiswa = Auth::user()->mahasiswa;

            $nomor = 'SRT-' . date('Ymd') . '-' . strtoupper(Str::random(4));

            $pengajuan = PengajuanSurat::create([
                'mahasiswa_id'    => $mahasiswa->id,
                'jenis_surat_id'  => $request->jenis_surat_id,
                'nomor_pengajuan' => $nomor,
                'keperluan'       => $request->keperluan,
                'status'          => 'menunggu',
            ]);

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $file) {
                    $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('pengajuan_dokumen', $filename, 'public');

                    DokumenPengajuan::create([
                        'pengajuan_surat_id' => $pengajuan->id,
                        'nama_dokumen'       => $file->getClientOriginalName(),
                        'file'               => $path,
                        'status'             => 'menunggu',
                        'keterangan'         => null,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('mahasiswa.pengajuan.show', $pengajuan)
                ->with('success', 'Pengajuan surat berhasil dikirim! Nomor: ' . $nomor);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(PengajuanSurat $pengajuan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if ($pengajuan->mahasiswa_id !== $mahasiswa->id) {
            abort(403, 'Anda tidak berhak mengakses pengajuan ini.');
        }

        $pengajuan->load(['jenisSurat', 'dokumenPengajuans']);

        return view('mahasiswa.pengajuan.show', compact('pengajuan'));
    }

    public function cancel(PengajuanSurat $pengajuan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if ($pengajuan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($pengajuan->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan yang sudah diproses tidak dapat dibatalkan.');
        }

        $pengajuan->update([
            'status'        => 'ditolak',
            'catatan_admin' => 'Dibatalkan oleh mahasiswa',
        ]);

        return redirect()
            ->route('mahasiswa.pengajuan.index')
            ->with('success', 'Pengajuan berhasil dibatalkan.');
    }

    public function download(PengajuanSurat $pengajuan)
    {
        $mahasiswa = Auth::user()->mahasiswa;

        if ($pengajuan->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }

        if ($pengajuan->status !== 'selesai' || !$pengajuan->file_surat) {
            return back()->with('error', 'Surat belum tersedia untuk diunduh.');
        }

        $path = storage_path('app/public/' . $pengajuan->file_surat);

        if (!file_exists($path)) {
            return back()->with('error', 'File surat tidak ditemukan.');
        }

        return response()->download($path, 'Surat_' . $pengajuan->nomor_pengajuan . '.pdf');
    }
}