<?php

namespace App\Http\Controllers;

use App\HomeroomTeacher;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;

class TeachersController extends Controller
{
    // ================================================================
    // ADMIN — CRUD Guru
    // ================================================================

    public function index()
    {
        $teachers = Teacher::all();

        return view('guru.index', compact('teachers'));
    }

    public function create()
    {
        $nrgTerakhir = Teacher::max('nrg');

        return view('guru.create', compact('nrgTerakhir'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nrg'           => 'required|unique:teachers',
            'nama'          => 'required',
            'email'         => 'required|unique:users|email',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama'         => 'required',
            'telp'          => 'required',
            'alamat'        => 'required',
            'foto'          => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user                 = new \App\User;
        $user->role           = 'guru';
        $user->name           = $request->nama;
        $user->username       = $request->nrg;
        $user->email          = $request->email;
        $user->password       = bcrypt('123');
        $user->remember_token = str_random(60);
        $user->save();

        $request->request->add([
            'user_id' => $user->id
        ]);

        $teacher = Teacher::create(
            $request->except(['foto', '_token', 'email'])
        );

        if ($request->hasFile('foto')) {

            $file     = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('img/guru'), $namaFile);

            $teacher->foto = $namaFile;
            $teacher->save();
        }

        return redirect('/teachers')
            ->with('status', 'Data berhasil ditambah');
    }

    public function show(Teacher $teacher)
    {
        $schedules = \App\Schedule::with([
                            'classLearn.classRoom',
                            'classLearn.subject',
                            'semester'
                        ])
                        ->where('teacher_id', $teacher->id)
                        ->get();

        return view('guru.profil', compact(
            'teacher',
            'schedules'
        ));
    }

    public function edit(Teacher $teacher)
    {
        return view('guru.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $request->validate([
            'nama'          => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama'         => 'required',
            'alamat'        => 'required',
            'foto'          => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);

        $teacher->nrg           = $request->nrg;
        $teacher->nama          = $request->nama;
        $teacher->tempat_lahir  = $request->tempat_lahir;
        $teacher->tanggal_lahir = $request->tanggal_lahir;
        $teacher->jenis_kelamin = $request->jenis_kelamin;
        $teacher->telp          = $request->telp;
        $teacher->agama         = $request->agama;
        $teacher->alamat        = $request->alamat;

        if ($request->hasFile('foto')) {

            if (
                !empty($teacher->foto) &&
                File::exists(public_path('img/guru/' . $teacher->foto))
            ) {
                File::delete(public_path('img/guru/' . $teacher->foto));
            }

            $file     = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('img/guru'), $namaFile);

            $teacher->foto = $namaFile;
        }

        $teacher->save();

        return redirect('/teachers')
            ->with('status', 'Data guru berhasil diubah');
    }

    public function destroy(Teacher $teacher)
    {
        if (
            !empty($teacher->foto) &&
            File::exists(public_path('img/guru/' . $teacher->foto))
        ) {
            File::delete(public_path('img/guru/' . $teacher->foto));
        }

        \App\User::destroy($teacher->user_id);

        Teacher::destroy($teacher->id);

        return redirect('/teachers')
            ->with('status', 'Data berhasil dihapus');
    }

    public function getdatateachers()
    {
        $teachers = Teacher::select('teachers.*');

        return \DataTables::eloquent($teachers)
            ->addIndexColumn()
            ->addColumn('aksi', function ($t) {

                return '
                    <a href="/teachers/' . $t->id . '" class="btn btn-info btn-sm">
                        detail
                    </a>

                    <a href="/teachers/' . $t->id . '/edit" class="btn btn-warning btn-sm">
                        edit
                    </a>

                    <form action="/teachers/' . $t->id . '" method="post" class="d-inline delete">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="hidden" name="_method" value="DELETE">

                        <button type="submit" class="btn btn-danger btn-sm">
                            hapus
                        </button>
                    </form>
                ';
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    // ================================================================
    // GURU — PROFIL
    // ================================================================

    public function profileTeacher()
    {
        $teacher = Teacher::find(auth()->user()->teacher->id);

        return view('user.guru.profil', compact('teacher'));
    }

    public function editProfileTeacher()
    {
        $teacher = Teacher::find(auth()->user()->teacher->id);

        return view('user.guru.edit_profil', compact('teacher'));
    }

    public function updateTeacher(Request $request, Teacher $teacher)
    {
        $request->validate([
            'nama'          => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'agama'         => 'required',
            'alamat'        => 'required',
            'foto'          => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);

        $teacher->nama          = $request->nama;
        $teacher->tempat_lahir  = $request->tempat_lahir;
        $teacher->tanggal_lahir = $request->tanggal_lahir;
        $teacher->jenis_kelamin = $request->jenis_kelamin;
        $teacher->telp          = $request->telp;
        $teacher->agama         = $request->agama;
        $teacher->alamat        = $request->alamat;

        if ($request->hasFile('foto')) {

            if (
                !empty($teacher->foto) &&
                File::exists(public_path('img/guru/' . $teacher->foto))
            ) {
                File::delete(public_path('img/guru/' . $teacher->foto));
            }

            $file     = $request->file('foto');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('img/guru'), $namaFile);

            $teacher->foto = $namaFile;
        }

        $teacher->save();

        return redirect('/teacher/profile')
            ->with('status', 'Data profil berhasil diubah');
    }

    // ================================================================
    // GURU — JADWAL
    // ================================================================

    public function schedulesTeacher(Request $request)
    {
        $semesters = \App\Semester::all();

        $schedules = collect();

        if ($request->filled('semester')) {

            $schedules = \App\Schedule::with([
                                'classLearn.classRoom',
                                'classLearn.subject',
                                'semester'
                            ])
                            ->where('teacher_id', auth()->user()->teacher->id)
                            ->where('semester_id', $request->semester)
                            ->whereHas('classLearn')
                            ->orderByRaw("
                                FIELD(
                                    hari,
                                    'Senin',
                                    'Selasa',
                                    'Rabu',
                                    'Kamis',
                                    'Jumat',
                                    'Sabtu'
                                )
                            ")
                            ->orderBy('jam_mulai')
                            ->get();
        }

        return view('user.guru.jadwal', compact(
            'schedules',
            'semesters'
        ));
    }

    // ================================================================
    // GURU — NILAI
    // ================================================================

    public function indexGradeTeacher(Request $request)
    {
        $teacherId = auth()->user()->teacher->id;

        $classes = \App\Schedule::with([
                            'classLearn.classRoom',
                            'classLearn.subject',
                            'semester'
                        ])
                        ->where('teacher_id', $teacherId)
                        ->get();

        $semesters     = \App\Semester::all();
        $grades        = collect();
        $classSelected = null;

        if (
            $request->filled('kelas') &&
            $request->filled('semester')
        ) {

            $classSelected = \App\ClassRoom::find($request->kelas);

            $subjectIds = \App\Schedule::with('classLearn')
                            ->where('teacher_id', $teacherId)
                            ->where('semester_id', $request->semester)
                            ->get()
                            ->filter(function ($schedule) use ($request) {

                                return optional(
                                    optional($schedule->classLearn)->classRoom
                                )->id == $request->kelas;

                            })
                            ->pluck('classLearn.subject_id')
                            ->unique();

            $grades = \App\Grade::with([
                            'classStudent.student',
                            'subject',
                            'semester'
                        ])
                        ->whereIn('subject_id', $subjectIds)
                        ->where('semester_id', $request->semester)
                        ->where('teacher_id', $teacherId)
                        ->get();

            $grades->map(function ($grade) {

                $rata2tugas = (
                    $grade->nilai_tugas_1 +
                    $grade->nilai_tugas_2
                ) / 2;

                $grade->rata2 =
                    ($rata2tugas * 0.25) +
                    ($grade->nilai_uts * 0.35) +
                    ($grade->nilai_uas * 0.40);

                return $grade;
            });
        }

        return view('user.guru.nilai.index', compact(
            'classes',
            'semesters',
            'grades',
            'classSelected'
        ));
    }

    public function createGradeTeacher($class_id, $semester_id, Request $request)
    {
        $teacherId = auth()->user()->teacher->id;

        $id        = $request->subject;
        $semester  = \App\Semester::find($semester_id);
        $class     = \App\ClassRoom::find($class_id);

        $schedule = \App\Schedule::with([
                            'classLearn.subject',
                            'classLearn.classRoom'
                        ])
                        ->where('semester_id', $semester_id)
                        ->where('teacher_id', $teacherId)
                        ->get()
                        ->filter(function ($item) use ($class_id) {

                            return optional(
                                optional($item->classLearn)->classRoom
                            )->id == $class_id;

                        });

        if ($request->filled('subject')) {

            $students = DB::table('class_students')
                ->where('class_students.class_room_id', $class_id)

                ->join(
                    'students',
                    'students.id',
                    '=',
                    'class_students.student_id'
                )

                ->select(
                    'students.nama',
                    'students.id as student_id',
                    'class_students.*'
                )

                ->whereNotExists(function ($query) use ($id, $semester_id) {

                    $query->select(DB::raw(1))
                        ->from('grades')

                        ->whereRaw(
                            'grades.subject_id = ' . (int) $id
                        )

                        ->whereRaw(
                            'grades.semester_id = ' . (int) $semester_id
                        )

                        ->whereRaw(
                            'grades.class_student_id = class_students.id'
                        );
                })

                ->get();

            return view(
                'user.guru.nilai.create',
                compact(
                    'class',
                    'schedule',
                    'semester',
                    'students'
                )
            );
        }

        return view(
            'user.guru.nilai.create',
            compact(
                'class',
                'schedule',
                'semester'
            )
        );
    }

    public function storeGradeTeacher(Request $request)
    {
        $request->validate([
            'subject_id'    => 'required',
            'nilai_tugas_1' => 'required|array',
            'nilai_tugas_2' => 'required|array',
            'nilai_uts'     => 'required|array',
            'nilai_uas'     => 'required|array',
        ]);

        $lastKey = 0;

        foreach ($request->class_student_id as $key => $value) {

            \App\Grade::create([

                'class_student_id' => $value,
                'subject_id'       => $request->subject_id,

                'semester_id'      => $request->semester_id[$key],
                'teacher_id'       => $request->teacher_id[$key],

                'nilai_tugas_1'    => $request->nilai_tugas_1[$key],
                'nilai_tugas_2'    => $request->nilai_tugas_2[$key],
                'nilai_uts'        => $request->nilai_uts[$key],
                'nilai_uas'        => $request->nilai_uas[$key],

                'student_id'       => $request->student_id[$key],
            ]);

            $lastKey = $key;
        }

        return redirect(
            'teacher/grades?kelas=' .
            $request->class_room_id[$lastKey] .
            '&semester=' .
            $request->semester_id[$lastKey]
        )->with('status', 'Data nilai berhasil ditambah!');
    }

    // ================================================================
    // GURU — WALI KELAS
    // ================================================================

    public function indexHomeroomTeacher(Request $request)
    {
        $semesters = \App\Semester::all();

        $homeroomTeachers = HomeroomTeacher::where(
                                'semester_id',
                                $request->semester
                            )
                            ->where(
                                'teacher_id',
                                auth()->user()->teacher->id
                            )
                            ->get();

        return view(
            'user.guru.wali_kelas.index',
            compact('semesters', 'homeroomTeachers')
        );
    }

    public function showStudentHomeroomTeacher($class_id, $semester_id)
    {
        $semester = \App\Semester::find($semester_id);

        $s = \App\Semester::where(
                'tahun_ajaran',
                $semester->tahun_ajaran
            )->get();

        $classStudents = \App\ClassStudent::where(
                                'class_room_id',
                                $class_id
                            )
                            ->where(
                                'semester_id',
                                $semester_id
                            )
                            ->get();

        return view(
            'user.guru.wali_kelas.show_student',
            compact('classStudents', 's')
        );
    }

    public function showGradeHomeroomTeacher($class_student_id, $semester_id)
    {
        $student = \App\ClassStudent::find($class_student_id);

        $nilai = DB::table('subjects')

            ->select(
                'subjects.*',
                'grades.*',
                'subjects.nama'
            )

            ->leftJoin('grades', function ($leftJoin) use (
                $class_student_id,
                $semester_id
            ) {

                $leftJoin->on(
                    'grades.subject_id',
                    '=',
                    'subjects.id'
                );

                $leftJoin->where(
                    'grades.semester_id',
                    '=',
                    $semester_id
                );

                $leftJoin->where(
                    'grades.class_student_id',
                    '=',
                    $class_student_id
                );
            })

            ->get();

        return view(
            'user.guru.wali_kelas.show_grade',
            compact(
                'student',
                'nilai',
                'semester_id'
            )
        );
    }
    public function editGradeTeacher($id)
{
    $grade = \App\Grade::with([
                    'student',
                    'subject',
                    'semester'
                ])
                ->findOrFail($id);

    // Proteksi agar guru tidak bisa edit nilai guru lain
    if ($grade->teacher_id != auth()->user()->teacher->id) {
        abort(403);
    }

    return view(
        'user.guru.nilai.edit',
        compact('grade')
    );
}

public function updateGradeTeacher(Request $request, $id)
{
    $request->validate([
        'nilai_tugas_1' => 'required|numeric|min:0|max:100',
        'nilai_tugas_2' => 'required|numeric|min:0|max:100',
        'nilai_uts'     => 'required|numeric|min:0|max:100',
        'nilai_uas'     => 'required|numeric|min:0|max:100',
    ]);

    $grade = \App\Grade::findOrFail($id);

    // Proteksi guru lain
    if ($grade->teacher_id != auth()->user()->teacher->id) {
        abort(403);
    }

    $grade->nilai_tugas_1 = $request->nilai_tugas_1;
    $grade->nilai_tugas_2 = $request->nilai_tugas_2;
    $grade->nilai_uts     = $request->nilai_uts;
    $grade->nilai_uas     = $request->nilai_uas;

    $grade->save();

    return redirect(
        '/teacher/grades?kelas=' .
        request('kelas') .
        '&semester=' .
        request('semester')
    )->with('status', 'Data nilai berhasil diubah');
}
}