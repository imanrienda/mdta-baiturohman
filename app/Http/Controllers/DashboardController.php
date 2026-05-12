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

        return view(
            'user.admin.dashboard',
            compact(
                'lakiLaki',
                'perempuan',
                'guruLakiLaki',
                'guruPerempuan'
            )
        );
    }

    // -------------------------------------------------------
    // SISWA — Dashboard
    // -------------------------------------------------------
    public function student()
{
    $student_id = auth()->user()->student->id;

    // =====================================================
    // PENGUMUMAN
    // =====================================================
    $informations = Information::where('publish', 1)
        ->latest()
        ->take(3)
        ->get();

    // =====================================================
    // DATA KELAS SISWA
    // =====================================================
    $classes = \App\ClassStudent::where(
                    'student_id',
                    $student_id
                )->get();

    // =====================================================
    // DATA NILAI SISWA
    // =====================================================
    $grades = \App\Grade::with('semester')
                ->where('student_id', $student_id)
                ->get();

    // =====================================================
    // GROUP BERDASARKAN SEMESTER
    // =====================================================
    $grouped = $grades->groupBy('semester_id');

    $semester = [];
    $rata2    = [];
    $jmlMapel = [];

    foreach ($grouped as $semesterId => $items) {

        $sum = 0;

        foreach ($items as $grade) {

            $rata2Tugas = (
                ($grade->nilai_tugas_1 ?? 0) +
                ($grade->nilai_tugas_2 ?? 0)
            ) / 2;

            $nilaiAkhir =
                ($rata2Tugas * 0.25) +
                (($grade->nilai_uts ?? 0) * 0.35) +
                (($grade->nilai_uas ?? 0) * 0.40);

            $sum += $nilaiAkhir;
        }

        $average = $items->count() > 0
            ? round($sum / $items->count(), 2)
            : 0;

        $semesterModel = $items->first()->semester;

        $semester[] =
            $semesterModel->tahun_ajaran .
            ' | ' .
            $semesterModel->semester;

        $rata2[] = $average;

        $jmlMapel[] = $items->count();
    }

    return view(
        'user.siswa.dashboard',
        compact(
            'informations',
            'semester',
            'rata2',
            'jmlMapel'
        )
    );
}

    // -------------------------------------------------------
    // SISWA — Semua Pengumuman
    // -------------------------------------------------------
    public function allInformations()
    {
        $informations = Information::where('publish', 1)
            ->latest()
            ->get();

        return view(
            'user.siswa.allInformations',
            compact('informations')
        );
    }

    // -------------------------------------------------------
    // SISWA — Detail Pengumuman
    // -------------------------------------------------------
    public function showInformation($information_id)
    {
        $information = Information::findOrFail($information_id);

        return view(
            'user.siswa.showInformation',
            compact('information')
        );
    }

    // -------------------------------------------------------
    // GURU
    // -------------------------------------------------------
public function teacher()
{
    $teacher = Teacher::find(auth()->user()->teacher->id);

    $hariIni = Carbon::now()
        ->locale('id')
        ->isoFormat('dddd');

    // ==============================
    // JADWAL HARI INI
    // ==============================
    $schedules = Schedule::with([
            'classLearn.classRoom',
            'classLearn.subject',
        ])
        ->where('teacher_id', $teacher->id)
        ->where('hari', $hariIni)
        ->orderBy('jam_mulai')
        ->get();

    // ==============================
    // AMBIL KELAS BERDASARKAN
    // CLASS LEARN
    // ==============================
    $kelasIds = Schedule::with('classLearn.classRoom')
        ->where('teacher_id', $teacher->id)
        ->get()
        ->pluck('classLearn.classRoom.id')
        ->unique()
        ->filter();

    // ==============================
    // TOTAL SISWA
    // ==============================
    $totalSiswa = \App\ClassStudent::whereIn(
            'class_room_id',
            $kelasIds
        )
        ->distinct('student_id')
        ->count('student_id');

    // ==============================
    // TOTAL KELAS
    // ==============================
    $totalKelas = $kelasIds->count();

    // ==============================
    // TOTAL JADWAL
    // ==============================
    $totalJadwal = Schedule::where(
            'teacher_id',
            $teacher->id
        )
        ->count();

    return view(
        'user.guru.dashboard',
        compact(
            'teacher',
            'schedules',
            'totalSiswa',
            'totalKelas',
            'totalJadwal'
        )
    );
}
}