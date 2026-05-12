<?php

namespace App\Http\Controllers;

use App\Student;
use App\Grade;
use Illuminate\Http\Request;
use PDF;

class ExportsController extends Controller
{
    // =========================================================
    // EXPORT DATA SISWA
    // =========================================================
    public function exportSiswaPDF()
    {
        $students = Student::all();

        $pdf = PDF::loadView(
            'export.siswapdf',
            compact('students')
        );

        return $pdf->download('siswa.pdf');
    }

    // =========================================================
    // EXPORT JADWAL
    // =========================================================
    public function exportJadwalPDF($kelas, $semester)
    {
        $schedule = \App\Schedule::where(
                'class_room_id',
                $kelas
            )
            ->where(
                'semester_id',
                $semester
            )
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
            ->get();

        $pdf = PDF::loadView(
            'export.jadwalpdf',
            compact('schedule')
        );

        return $pdf->download('jadwal.pdf');
    }

    // =========================================================
    // EXPORT NILAI ADMIN
    // =========================================================
    public function exportNilaiPDF($kelas, $semester)
    {
        $grades = Grade::with([
                'classStudent.student',
                'classStudent.classRoom',
                'subject',
                'semester',
            ])

            ->whereHas('classStudent', function ($query) use ($kelas) {

                $query->where(
                    'class_room_id',
                    $kelas
                );
            })

            ->where(
                'semester_id',
                $semester
            )

            ->get();

        $grades->map(function ($grade) {

            $rata2tugas = (
                ($grade->nilai_tugas_1 ?? 0) +
                ($grade->nilai_tugas_2 ?? 0)
            ) / 2;

            $grade->rata2 =
                ($rata2tugas * 0.25) +
                (($grade->nilai_uts ?? 0) * 0.35) +
                (($grade->nilai_uas ?? 0) * 0.40);

            return $grade;
        });

        $pdf = PDF::loadView(
            'export.nilaipdf',
            compact('grades')
        );

        return $pdf->download('nilai.pdf');
    }

    // =========================================================
    // EXPORT NILAI SISWA
    // =========================================================
    public function exportNilaiSiswaPDF($kelas, $semester)
    {
        $studentId = auth()->user()->student->id;

        $student = \App\ClassStudent::with([
                'student',
                'classRoom'
            ])
            ->findOrFail($kelas);

        $grades = Grade::with([
                'subject',
                'semester',
                'classStudent.student',
                'classStudent.classRoom',
            ])

            ->where(
                'student_id',
                $studentId
            )

            ->where(
                'class_student_id',
                $kelas
            )

            ->where(
                'semester_id',
                $semester
            )

            ->get();

        $grades->map(function ($grade) {

            $rata2tugas = (
                ($grade->nilai_tugas_1 ?? 0) +
                ($grade->nilai_tugas_2 ?? 0)
            ) / 2;

            $grade->rata2 =
                ($rata2tugas * 0.25) +
                (($grade->nilai_uts ?? 0) * 0.35) +
                (($grade->nilai_uas ?? 0) * 0.40);

            return $grade;
        });

        $sum = 0;
        $hitung = 0;

        foreach ($grades as $grade) {

            $sum += $grade->rata2;

            if ($grade->rata2 > 0) {
                $hitung++;
            }
        }

        $total = $hitung > 0
            ? round($sum / $hitung, 2)
            : 0;

        $semesterData = \App\Semester::find($semester);

        $pdf = PDF::loadView(
            'export.nilai_siswa_pdf',
            [
                'grades'   => $grades,
                'student'  => $student,
                'semester' => $semesterData,
                'total'    => $total,
            ]
        );

        return $pdf->download('nilai-siswa.pdf');
    }
}