<?php

namespace App\Http\Controllers;

use App\ClassRoom;
use App\ClassStudent;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class StudentsController extends Controller
{
    // ================================================================
    // ADMIN — CRUD Siswa
    // ================================================================

    public function index()
    {
        $students = Student::all();
        return view('siswa.index', compact('students'));
    }

    public function create()
    {
        $nisTerakhir = Student::max('nis');
        $classes     = \App\ClassRoom::all();
        return view('siswa.create', compact('nisTerakhir', 'classes'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'nis'           => 'required|unique:students|min:5',
                'nama'          => 'required',
                'email'         => 'required|unique:users|email',
                'tempat_lahir'  => 'required',
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'agama'         => 'required',
                'alamat'        => 'required',
                'foto'          => 'nullable|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'required' => ':attribute wajib diisi',
                'min'      => ':attribute minimal :min karakter',
                'unique'   => ':attribute sudah terdaftar',
                'email'    => ':attribute yang diisi bukan email',
                'mimes'    => ':attribute bukan file gambar',
                'max'      => ':attribute maksimal 2MB',
            ]
        );

        $user                 = new \App\User;
        $user->role           = 'siswa';
        $user->name           = $request->nama;
        $user->username       = $request->nis;
        $user->email          = $request->email;
        $user->password       = bcrypt('123');
        $user->remember_token = str_random(60);
        $user->save();

        $request->request->add(['user_id' => $user->id]);
        $student = Student::create($request->except(['foto', '_token']));

        if ($request->hasFile('foto')) {
            $file     = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img'), $namaFile);
            $student->foto = $namaFile;
            $student->save();
        }

        return redirect('/students')->with('status', 'Data berhasil ditambah');
    }

    public function show(Student $student)
    {
        $student->load('user');

        $classStudent = \App\ClassStudent::where('student_id', $student->id)->first();

        if (!$classStudent) {
            $grades = collect();
            return view('siswa.profil', compact('student', 'grades'));
        }

        $grades = \App\Grade::where('class_student_id', $classStudent->id)->get();
        return view('siswa.profil', compact('student', 'grades'));
    }

    public function edit(Student $student)
    {
        return view('siswa.edit', ['student' => $student]);
    }

    /**
     * ✅ FIX: update() — ditambahkan logika upload & hapus foto lama
     */
    public function update(Request $request, Student $student)
    {
        $request->validate(
            [
                'nama'          => 'required',
                'tempat_lahir'  => 'required',
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'agama'         => 'required',
                'alamat'        => 'required',
                'foto'          => 'nullable|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'required' => ':attribute wajib diisi',
                'min'      => ':attribute minimal :min karakter',
                'unique'   => ':attribute sudah terdaftar',
                'email'    => ':attribute yang diisi bukan email',
                'mimes'    => ':attribute bukan file gambar',
                'max'      => ':attribute maksimal 2MB',
            ]
        );

        // Gunakan instance $student yang sudah di-inject langsung (hindari query ulang yang tidak perlu)
        $student->nis           = $request->nis;
        $student->nama          = $request->nama;
        $student->tempat_lahir  = $request->tempat_lahir;
        $student->tanggal_lahir = $request->tanggal_lahir;
        $student->jenis_kelamin = $request->jenis_kelamin;
        $student->agama         = $request->agama;
        $student->alamat        = $request->alamat;

        // ✅ FIX: Proses upload foto jika ada file baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada dan file-nya exist
            if (!empty($student->foto) && File::exists(public_path('img/' . $student->foto))) {
                File::delete(public_path('img/' . $student->foto));
            }

            $file     = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img'), $namaFile);
            $student->foto = $namaFile;
        }

        $student->save();

        return redirect('/students')->with('status', 'Data berhasil diubah');
    }

    public function destroy(Student $student)
    {
        if (!empty($student->foto) && File::exists(public_path('img/' . $student->foto))) {
            File::delete(public_path('img/' . $student->foto));
        }
        \App\User::destroy($student->user_id);
        Student::destroy($student->id);
        return redirect('/students')->with('status', 'Data berhasil dihapus');
    }

    public function getdatastudent()
    {
        $students = Student::select('students.*');

        return \DataTables::eloquent($students)
            ->addIndexColumn()
            ->addColumn('aksi', function ($s) {
                return '
                    <a href="/students/' . $s->id . '" class="btn btn-info btn-sm">detail</a>
                    <a href="/students/' . $s->id . '/edit" class="btn btn-warning btn-sm">edit</a>
                    <form action="/students/' . $s->id . '" method="post" class="d-inline delete">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger delete btn-sm">hapus</button>
                    </form>';
            })
            ->rawColumns(['aksi', 'kelas'])
            ->tojson();
    }

    // ================================================================
    // ADMIN — Kelas Siswa
    // ================================================================

    public function classStudent(Request $request)
    {
        $semester_id   = $request->semester;
        $classes       = \App\ClassRoom::all();
        $semesters     = \App\Semester::all();
        $classStudents = \App\ClassStudent::where('semester_id', '=', $semester_id)->get();

        if ($request->all()) {
            $studentNotExists = DB::table('students')
                ->select('students.id', 'students.nama')
                ->whereNotExists(function ($query) use ($semester_id) {
                    $query->select(DB::raw(1))
                        ->from('class_students')
                        ->whereRaw('class_students.semester_id =' . $semester_id)
                        ->whereRaw('class_students.student_id = students.id');
                })
                ->get();

            return view('kelas_siswa.index', compact('classStudents', 'classes', 'semesters', 'studentNotExists'));
        }

        return view('kelas_siswa.index', compact('classStudents', 'classes', 'semesters'));
    }

    public function storeClassStudentByStudent(Request $request)
    {
        foreach ($request->student_id as $key => $value) {
            ClassStudent::create([
                'student_id'    => $value,
                'class_room_id' => $request->class_room_id,
                'semester_id'   => $request->semester_id,
            ]);
        }

        return redirect('class-students?semester=' . $request->semester_id)
            ->with('status', 'Data kelas siswa berhasil ditambah!');
    }

    public function destroyClassStudent(ClassStudent $classStudent)
    {
        ClassStudent::destroy($classStudent->id);
        return redirect('class-students?semester=' . $classStudent->semester_id)
            ->with('status', 'Data kelas siswa berhasil dihapus!');
    }

    public function createClassStudent($semester_id)
    {
        $semester = \App\Semester::find($semester_id);
        return view('kelas_siswa.create', compact('semester'));
    }

    // ================================================================
    // SISWA — Profil & Edit
    // ================================================================

    public function profileStudent()
    {
        $student = Student::with('user')->find(auth()->user()->student->id);
        return view('user.siswa.profil', compact('student'));
    }

    public function editStudent()
    {
        $student = Student::find(auth()->user()->student->id);
        return view('user.siswa.edit_profil', compact('student'));
    }

    /**
     * ✅ FIX: updateStudent() — ditambahkan logika upload & hapus foto lama
     * Route yang dipakai: PUT /student/edit/{student}
     */
    public function updateStudent(Request $request, Student $student)
    {
        $request->validate(
            [
                'nama'          => 'required',
                'tempat_lahir'  => 'required',
                'tanggal_lahir' => 'required',
                'jenis_kelamin' => 'required',
                'agama'         => 'required',
                'alamat'        => 'required',
                'foto'          => 'nullable|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'required' => ':attribute wajib diisi',
                'min'      => ':attribute minimal :min karakter',
                'unique'   => ':attribute sudah terdaftar',
                'email'    => ':attribute yang diisi bukan email',
                'mimes'    => ':attribute bukan file gambar',
                'max'      => ':attribute maksimal 2MB',
            ]
        );

        $student->nama          = $request->nama;
        $student->tempat_lahir  = $request->tempat_lahir;
        $student->tanggal_lahir = $request->tanggal_lahir;
        $student->jenis_kelamin = $request->jenis_kelamin;
        $student->agama         = $request->agama;
        $student->alamat        = $request->alamat;

        // ✅ FIX: Proses upload foto jika ada file baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada dan file-nya exist
            if (!empty($student->foto) && File::exists(public_path('img/' . $student->foto))) {
                File::delete(public_path('img/' . $student->foto));
            }

            $file     = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img'), $namaFile);
            $student->foto = $namaFile;
        }

        $student->save();

        return redirect('/student/profile')->with('status', 'Data berhasil diubah');
    }

    // ================================================================
    // SISWA — Jadwal
    // ================================================================

    public function schedulesStudent(Request $request)
    {
        $classes   = \App\ClassStudent::where('student_id', '=', auth()->user()->student->id)->get();
        $semesters = \App\Semester::all();
        $schedules = \App\Schedule::where('class_room_id', '=', $request->kelas)
            ->where('semester_id', '=', $request->semester)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->get();

        return view('user.siswa.jadwal', compact('schedules', 'classes', 'semesters'));
    }

 // ================================================================
// SISWA — Nilai
// ================================================================

public function gradesStudent(Request $request)
{
    $studentId = auth()->user()->student->id;

    $classes = \App\ClassStudent::with('classRoom')
                    ->where('student_id', $studentId)
                    ->get();

    $semesters = \App\Semester::all();

    $student = null;

    $nilai = collect();

    $total = 0;

    if (
        $request->filled('kelas') &&
        $request->filled('semester')
    ) {

        $student = \App\ClassStudent::with('classRoom')
                        ->find($request->kelas);

        $nilai = \App\Grade::with([
                        'subject',
                        'semester'
                    ])
                    ->where('student_id', $studentId)
                    ->where('semester_id', $request->semester)
                    ->get();

        $nilai->map(function ($n) {

            $rata2tugas = (
                ($n->nilai_tugas_1 ?? 0) +
                ($n->nilai_tugas_2 ?? 0)
            ) / 2;

            $n->rata2 =
                ($rata2tugas * 0.25) +
                (($n->nilai_uts ?? 0) * 0.35) +
                (($n->nilai_uas ?? 0) * 0.40);

            return $n;
        });

        $sum = 0;
        $hitung = 0;

        foreach ($nilai as $n) {

            $sum += $n->rata2;

            if ($n->rata2 > 0) {
                $hitung++;
            }
        }

        $total = $hitung > 0
            ? round($sum / $hitung, 2)
            : 0;
    }

    return view(
        'user.siswa.nilai',
        compact(
            'classes',
            'nilai',
            'semesters',
            'student',
            'total'
        )
    );
}
}