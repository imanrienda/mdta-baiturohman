<?php

namespace App\Http\Controllers;

use App\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    // ✅ Admin - list semua pendaftaran
    public function index()
    {
        $data = Pendaftaran::latest()->get();
        return view('pendaftaran.index', compact('data'));
    }

    // ✅ PUBLIK - form untuk calon siswa (tanpa login)
    public function create()
    {
        return view('pendaftaran.create');
    }

    // ✅ PUBLIK - simpan dari form calon siswa
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'nama_ortu'     => 'required|string',
            'no_hp_ortu'    => 'required|string|max:15',
            'kelas_tujuan'  => 'required|string',
            'foto'          => 'nullable|image|max:2048',
            'dokumen'       => 'nullable|mimes:pdf,jpg,png|max:4096',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_pendaftaran', 'public');
        }

        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('dokumen_pendaftaran', 'public');
        }

        $pendaftaran = Pendaftaran::create($data);

        return redirect()->route('pendaftaran.show', $pendaftaran->id)
                         ->with('success', 'Pendaftaran berhasil dikirim! Simpan nomor pendaftaran Anda.');
    }

    // ✅ PUBLIK - lihat bukti pendaftaran
    public function show($id)
    {
        $data = Pendaftaran::findOrFail($id);
        return view('pendaftaran.show', compact('data'));
    }

    // ✅ ADMIN - form tambah manual
    public function createAdmin()
    {
        return view('pendaftaran.create_admin');
    }

    // ✅ ADMIN - simpan tambah manual
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'tempat_lahir'  => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required|string',
            'nama_ortu'     => 'required|string',
            'no_hp_ortu'    => 'required|string|max:15',
            'kelas_tujuan'  => 'required|string',
            'foto'          => 'nullable|image|max:2048',
            'dokumen'       => 'nullable|mimes:pdf,jpg,png|max:4096',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_pendaftaran', 'public');
        }

        if ($request->hasFile('dokumen')) {
            $data['dokumen'] = $request->file('dokumen')->store('dokumen_pendaftaran', 'public');
        }

        Pendaftaran::create($data);

        return redirect()->route('pendaftaran.index')
                         ->with('status', 'Data pendaftaran berhasil ditambahkan!');
    }

    // ✅ ADMIN - detail pendaftaran
    public function detail($id)
    {
        $data = Pendaftaran::findOrFail($id);
        return view('pendaftaran.detail', compact('data'));
    }

    // ✅ ADMIN - approve / tolak
    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $request->status]);

        return redirect()->route('pendaftaran.index')
                         ->with('status', 'Status pendaftaran berhasil diperbarui!');
    }
}