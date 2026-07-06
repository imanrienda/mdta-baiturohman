<?php

namespace App\Http\Controllers;

use App\Pendaftaran;
use App\Semester;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')->get();
        return view('pendaftaran.create', compact('semesters'));
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
            'semester_id'   => 'required|exists:semesters,id',
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
        $semesters = Semester::orderBy('tahun_ajaran', 'desc')->get();
        return view('pendaftaran.create_admin', compact('semesters'));
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
            'semester_id'   => 'required|exists:semesters,id',
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

    // ✅ ADMIN - approve / tolak + auto-create user & student
    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $request->status]);

        if ($request->status === 'diterima') {

            // Cek duplikat berdasarkan nama + tanggal lahir
            $sudahAda = \App\Student::where('nama', $pendaftaran->nama)
                            ->where('tanggal_lahir', $pendaftaran->tanggal_lahir)
                            ->exists();

            if (!$sudahAda) {
                // Generate NIS: tahun + id pendaftaran (contoh: 2026002)
                $nis = date('Y') . str_pad($pendaftaran->id, 3, '0', STR_PAD_LEFT);

                // Generate username unik dari nama depan (contoh: syahrur, syahrur01)
                $baseUsername = strtolower(explode(' ', $pendaftaran->nama)[0]);
                $baseUsername = substr(preg_replace('/[^a-z0-9]/', '', $baseUsername), 0, 8);
                $username     = $baseUsername;
                $counter      = 1;
                while (\App\User::where('username', $username)->exists()) {
                    $username = $baseUsername . str_pad($counter, 2, '0', STR_PAD_LEFT);
                    $counter++;
                }

                // Generate email unik dari username
                $email        = $username . '@siswa.sch.id';
                $emailCounter = 1;
                while (\App\User::where('email', $email)->exists()) {
                    $email = $username . $emailCounter . '@siswa.sch.id';
                    $emailCounter++;
                }

                // Password default: tanggal lahir format ddmmyyyy (contoh: 22032004)
                $passwordDefault = Carbon::parse($pendaftaran->tanggal_lahir)->format('dmY');

                // Buat akun User
                $user = \App\User::create([
                    'name'     => $pendaftaran->nama,
                    'username' => $username,
                    'email'    => $email,
                    'password' => bcrypt($passwordDefault),
                    'role'     => 'siswa',
                ]);

                // Buat data Student
                $student = \App\Student::create([
                    'nis'           => $nis,
                    'nama'          => $pendaftaran->nama,
                    'user_id'       => $user->id,
                    'tempat_lahir'  => $pendaftaran->tempat_lahir,
                    'tanggal_lahir' => $pendaftaran->tanggal_lahir,
                    'jenis_kelamin' => $pendaftaran->jenis_kelamin,
                    'alamat'        => $pendaftaran->alamat,
                    'foto'          => $pendaftaran->foto ?? null,
                    'agama'         => '-',
                ]);
            }
        }

        return redirect()->route('pendaftaran.index')
                         ->with('status', 'Status pendaftaran berhasil diperbarui!');
    }
}