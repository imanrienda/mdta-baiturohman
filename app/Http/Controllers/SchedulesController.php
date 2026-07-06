<?php

namespace App\Http\Controllers;

use App\ClassLearn;
use App\Schedule;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{
    public function index(Request $request)
    {
        $classStudents = \App\ClassRoom::all();
        $semesters     = \App\Semester::all();

        $schedule = Schedule::where('class_room_id', '=', $request->kelas)
            ->where('semester_id', $request->semester)
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')")
            ->get();

        return view('jadwal.index', compact('classStudents', 'semesters', 'schedule'));
    }

    public function create($class_room_id, $semester_id)
    {
        $semester     = \App\Semester::find($semester_id);
        $classStudent = \App\ClassStudent::where('class_room_id', $class_room_id)->first();

        $subjects = \App\Subject::orderBy('nama')->get();

        return view('jadwal.create', compact('classStudent', 'subjects', 'semester'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'hari'         => 'required',
                'jam_mulai'    => 'required',
                'jam_selesai'  => 'required',
                'subject_id'   => 'required',
                'teacher_id'   => 'required',
                'class_room_id'=> 'required',
                'semester_id'  => 'required',
            ],
            [
                'required' => 'field ini wajib diisi',
            ]
        );

        // Cari relasi class learn berdasarkan kelas + mapel
        $classLearn = ClassLearn::where('class_room_id', $request->class_room_id)
            ->where('subject_id', $request->subject_id)
            ->first();

        if (!$classLearn) {
            return redirect('schedules/' . $request->class_room_id . '/' . $request->semester_id . '/create')
                ->with('error', 'Class Learn belum dibuat!')
                ->withInput();
        }

        // Cek bentrok jadwal kelas
        $schedule = Schedule::where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('class_room_id', $request->class_room_id)
            ->where('semester_id', $request->semester_id)
            ->first();

        // Cek bentrok jadwal guru
        $teacher = Schedule::where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('teacher_id', $request->teacher_id)
            ->first();

        if ($schedule != null) {

            return redirect('schedules/' . $request->class_room_id . '/' . $request->semester_id . '/create')
                ->with('error', 'Data jadwal sudah ada!')
                ->withInput();

        } elseif ($teacher != null) {

            return redirect('schedules/' . $request->class_room_id . '/' . $request->semester_id . '/create')
                ->with('error', 'Jadwal guru bentrok!')
                ->withInput();

        } elseif ($request->jam_mulai == $request->jam_selesai) {

            return redirect('schedules/' . $request->class_room_id . '/' . $request->semester_id . '/create')
                ->with('error', 'Jam mulai & jam selesai tidak boleh sama!')
                ->withInput();

        } else {

            Schedule::create([
                'hari'            => $request->hari,
                'jam_mulai'       => $request->jam_mulai,
                'jam_selesai'     => $request->jam_selesai,
                'class_learn_id'  => $classLearn->id,
                'class_room_id'   => $request->class_room_id,
                'subject_id'      => $request->subject_id,
                'semester_id'     => $request->semester_id,
                'teacher_id'      => $request->teacher_id,
            ]);

            return redirect('schedules?kelas=' . $request->class_room_id . '&semester=' . $request->semester_id)
                ->with('status', 'Data jadwal berhasil ditambah!');
        }
    }

    public function show(Schedule $schedule)
    {
        //
    }

    public function edit(Schedule $schedule)
    {
        $semester     = \App\Semester::find($schedule->semester_id);
        $classStudent = \App\ClassStudent::where('class_room_id', $schedule->class_room_id)->first();
        $subjects     = \App\Subject::orderBy('nama')->get();

        // ✅ PERBAIKAN: kirim $classLearns ke view agar dropdown mata pelajaran bisa tampil
        $classLearns  = ClassLearn::where('class_room_id', $schedule->class_room_id)->get();

        return view('jadwal.edit', compact('schedule', 'subjects', 'semester', 'classStudent', 'classLearns'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate(
            [
                'hari'           => 'required',
                'jam_mulai'      => 'required',
                'jam_selesai'    => 'required',
                'class_learn_id' => 'required',
                'teacher_id'     => 'required',
            ],
            [
                'required' => 'field ini wajib diisi',
            ]
        );

        // Ambil class_learn berdasarkan pilihan user di form
        $classLearn = ClassLearn::find($request->class_learn_id);

        if (!$classLearn) {
            return redirect('schedules/' . $schedule->id . '/edit')
                ->with('error', 'Class Learn belum dibuat!')
                ->withInput();
        }

        // Cek bentrok jadwal kelas
        $cekSchedule = Schedule::where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('class_room_id', $schedule->class_room_id)
            ->where('semester_id', $schedule->semester_id)
            ->where('id', '!=', $schedule->id)
            ->first();

        // Cek bentrok jadwal guru
        $teacher = Schedule::where('hari', $request->hari)
            ->where('jam_mulai', $request->jam_mulai)
            ->where('teacher_id', $request->teacher_id)
            ->where('id', '!=', $schedule->id)
            ->first();

        if ($cekSchedule) {

            return redirect('schedules/' . $schedule->id . '/edit')
                ->with('error', 'Data jadwal sudah ada!')
                ->withInput();

        } elseif ($teacher) {

            return redirect('schedules/' . $schedule->id . '/edit')
                ->with('error', 'Jadwal guru bentrok!')
                ->withInput();

        } elseif ($request->jam_mulai == $request->jam_selesai) {

            return redirect('schedules/' . $schedule->id . '/edit')
                ->with('error', 'Jam mulai & jam selesai tidak boleh sama!')
                ->withInput();

        } else {

            $schedule->update([
                'hari'            => $request->hari,
                'jam_mulai'       => $request->jam_mulai,
                'jam_selesai'     => $request->jam_selesai,
                'class_learn_id'  => $classLearn->id,
                'subject_id'      => $classLearn->subject_id,
                'teacher_id'      => $request->teacher_id,
            ]);

            return redirect('schedules?kelas=' . $schedule->class_room_id . '&semester=' . $schedule->semester_id)
                ->with('status', 'Data jadwal berhasil diubah!');
        }
    }

    public function destroy(Schedule $schedule)
    {
        $classRoomId = $schedule->class_room_id;
        $semesterId  = $schedule->semester_id;

        Schedule::destroy($schedule->id);

        return redirect('schedules?kelas=' . $classRoomId . '&semester=' . $semesterId)
            ->with('status', 'Data jadwal berhasil dihapus');
    }
}
