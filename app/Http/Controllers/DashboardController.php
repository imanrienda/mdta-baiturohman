<?php

namespace App\Http\Controllers;

use App\Information;
use App\Student;
use App\Teacher;
use App\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // -------------------------------------------------------
    // ADMIN
    // -------------------------------------------------------
    public function index()
    {
        $lakiLaki      = Student::where('jenis_kelamin', 'Laki-laki')->count();
        $perempuan     = Student::where('jenis_kelamin', 'Perempuan')->count();
        $guruLakiLaki  = Teacher::where('jenis_kelamin', 'Laki-laki')->count();
        $guruPerempuan = Teacher::where('jenis_kelamin', 'Perempuan')->count();

        return view('user.admin.dashboard', compact('lakiLaki', 'perempuan', 'guruLakiLaki', 'guruPerempuan'));
    }

    // -------------------------------------------------------
    // SISWA
    // -------------------------------------------------------
    public function student()
    {
        $student_id   = auth()->user()->student->id;
        $informations = Information::all()->take(3);
        $classes      = \App\ClassStudent::where('student_id', $student_id)->get();

        $nilai = DB::table('grades as g')
            ->leftJoin('class_learns', 'g.class_learn_id', '=', 'class_learns.id')
            ->leftJoin('semesters', 'g.semester_id', '=', 'semesters.id')
            ->select(DB::raw('round(
                sum( ((g.nilai_tugas_1 + g.nilai_tugas_2) / 2 * 0.25) + (g.nilai_uts * 0.35) + (g.nilai_uas * 0.40) ) / count(class_learns.subject_id), 2
                ) as rata2, g.semester_id, class_learns.*, count(class_learns.subject_id) as jmlMapel, semesters.tahun_ajaran, semesters.semester'))
            ->where('g.student_id', '=', $student_id)
            ->groupBy('g.semester_id')
            ->get();

        $semester = [];
        $rata2    = [];
        $jmlMapel = [];

        foreach ($nilai as $grade) {
            $semester[] = $grade->tahun_ajaran . ' | ' . $grade->semester;
            $rata2[]    = $grade->rata2;
            $jmlMapel[] = $grade->jmlMapel;
        }

        return view('user.siswa.dashboard', compact('informations', 'semester', 'rata2', 'jmlMapel'));
    }

    public function showInformation($information_id)
    {
        $information = Information::find($information_id);
        return view('user.siswa.showInformation', compact('information'));
    }

    // -------------------------------------------------------
    // GURU
    // -------------------------------------------------------
    public function teacher()
    {
        // 1. Data guru yang sedang login
        $teacher = Teacher::find(auth()->user()->teacher->id);

        // 2. Nama hari ini (Senin, Selasa, dst.) — sesuai format kolom 'hari' di tabel schedules
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');

        // 3. Jadwal hari ini, urut jam mulai
        $schedules = \App\Schedule::with([
                            'classLearn.classRoom',
                            'classLearn.subject',
                        ])
                        ->where('teacher_id', $teacher->id)
                        ->where('hari', $hariIni)
                        ->orderBy('jam_mulai')
                        ->get();

        // 4. Semua kelas unik yang diajar guru ini (lintas semester)
        $kelasIds = \App\Schedule::where('teacher_id', $teacher->id)
                        ->with('classLearn.classRoom')
                        ->get()
                        ->pluck('classLearn.classRoom.id')
                        ->unique()
                        ->filter();

        // 5. Total siswa unik di kelas-kelas tersebut
        $totalSiswa = \App\ClassStudent::whereIn('class_room_id', $kelasIds)
                        ->distinct('student_id')
                        ->count('student_id');

        // 6. Total kelas unik yang diajar
        $totalKelas = $kelasIds->count();

        // 7. Total jadwal guru ini (semua hari/semester)
        $totalJadwal = \App\Schedule::where('teacher_id', $teacher->id)->count();

        return view('user.guru.dashboard', compact(
            'teacher',
            'schedules',
            'totalSiswa',
            'totalKelas',
            'totalJadwal'
        ));
    }
}