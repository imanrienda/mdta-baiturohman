<?php

namespace App\Http\Controllers;

use App\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradesController extends Controller
{
    // =========================================================
    // INDEX
    // =========================================================
    public function index(Request $request)
    {
        $classes   = \App\ClassRoom::all();
        $semesters = \App\Semester::all();

        $grades = collect();

        if (
            $request->filled('kelas') &&
            $request->filled('semester')
        ) {

            $grades = Grade::with([
                    'classStudent.student',
                    'classStudent.classRoom',
                    'subject',
                    'semester',
                ])

                ->whereHas('classStudent', function ($query) use ($request) {

                    $query->where(
                        'class_room_id',
                        $request->kelas
                    );
                })

                ->where(
                    'semester_id',
                    $request->semester
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
        }

        return view(
            'nilai.index',
            compact(
                'classes',
                'semesters',
                'grades'
            )
        );
    }

    // =========================================================
    // CREATE
    // =========================================================
    public function create($class_id, $semester_id, Request $request)
    {
        $semester = \App\Semester::findOrFail($semester_id);

        $class = \App\ClassRoom::findOrFail($class_id);

        $schedule = \App\Schedule::with([
                'classLearn.subject',
                'teacher'
            ])
            ->where('class_room_id', $class_id)
            ->where('semester_id', $semester_id)
            ->get();

        if ($request->filled('subject')) {

            $subject_id = $request->subject;

            $students = DB::table('class_students')

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

                ->where(
                    'class_students.class_room_id',
                    $class_id
                )

                ->whereNotExists(function ($query) use (
                    $subject_id,
                    $semester_id
                ) {

                    $query->select(DB::raw(1))
                        ->from('grades')

                        ->whereRaw(
                            'grades.class_student_id = class_students.id'
                        )

                        ->whereRaw(
                            'grades.subject_id = ' . (int) $subject_id
                        )

                        ->whereRaw(
                            'grades.semester_id = ' . (int) $semester_id
                        );
                })

                ->get();

            return view(
                'nilai.create',
                compact(
                    'class',
                    'schedule',
                    'semester',
                    'students'
                )
            );
        }

        return view(
            'nilai.create',
            compact(
                'class',
                'schedule',
                'semester'
            )
        );
    }

    // =========================================================
    // STORE
    // =========================================================
    public function store(Request $request)
    {
        $request->validate(
            [
                'subject_id'      => 'required',

                'nilai_tugas_1'   => 'required|array',
                'nilai_tugas_2'   => 'required|array',
                'nilai_uts'       => 'required|array',
                'nilai_uas'       => 'required|array',
            ]
        );

        $lastKey = null;

        foreach ($request->class_student_id as $key => $value) {

            Grade::create([

                'class_student_id' => $value,

                'student_id'       => $request->student_id[$key],

                'subject_id'       => $request->subject_id,

                'class_learn_id'   => $request->class_learn_id[$key] ?? 0,

                'semester_id'      => $request->semester_id[$key],

                'teacher_id'       => $request->teacher_id[$key],

                'nilai_tugas_1'    => $request->nilai_tugas_1[$key],

                'nilai_tugas_2'    => $request->nilai_tugas_2[$key],

                'nilai_uts'        => $request->nilai_uts[$key],

                'nilai_uas'        => $request->nilai_uas[$key],
            ]);

            $lastKey = $key;
        }

        $classRoomId = \App\ClassStudent::find(
            $request->class_student_id[$lastKey]
        )->class_room_id;

        return redirect(
            'grades?kelas=' .
            $classRoomId .
            '&semester=' .
            $request->semester_id[$lastKey]
        )->with(
            'status',
            'Data nilai berhasil ditambah!'
        );
    }

    // =========================================================
    // EDIT
    // =========================================================
    public function edit(Grade $grade)
    {
        $grade = Grade::with([
                'classStudent.student',
                'classStudent.classRoom',
                'subject',
                'semester'
            ])
            ->findOrFail($grade->id);

        return view('nilai.edit', compact('grade'));
    }

    // =========================================================
    // UPDATE
    // =========================================================
    public function update(Request $request, Grade $grade)
    {
        $request->validate(
            [
                'nilai_tugas_1' => 'required|numeric|min:0|max:100',
                'nilai_tugas_2' => 'required|numeric|min:0|max:100',
                'nilai_uts'     => 'required|numeric|min:0|max:100',
                'nilai_uas'     => 'required|numeric|min:0|max:100',
            ]
        );

        $grade->update([

            'nilai_tugas_1' => $request->nilai_tugas_1,

            'nilai_tugas_2' => $request->nilai_tugas_2,

            'nilai_uts'     => $request->nilai_uts,

            'nilai_uas'     => $request->nilai_uas,
        ]);

        $kelas = optional(
            $grade->classStudent
        )->class_room_id;

        return redirect(
            'grades?kelas=' .
            $kelas .
            '&semester=' .
            $grade->semester_id
        )->with(
            'status',
            'Data nilai berhasil diubah!'
        );
    }

    // =========================================================
    // DELETE
    // =========================================================
    public function destroy(Grade $grade)
    {
        $kelas = optional(
            $grade->classStudent
        )->class_room_id;

        $semester = $grade->semester_id;

        $grade->delete();

        return redirect(
            'grades?kelas=' .
            $kelas .
            '&semester=' .
            $semester
        )->with(
            'status',
            'Data nilai berhasil dihapus!'
        );
    }
}