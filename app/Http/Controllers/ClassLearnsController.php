<?php

namespace App\Http\Controllers;

use App\ClassLearn;
use App\ClassRoom;
use App\Teacher;
use Illuminate\Http\Request;

class ClassLearnsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kelas_ajar.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes   = ClassRoom::all();
        $teachers  = \App\Teacher::all();
        $semesters = \App\Semester::all();
        $subjects  = \App\Subject::all();
        return view('kelas_ajar.create', compact('classes', 'teachers', 'semesters', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'class_room_id' => 'required',
                'subject_id'    => 'required',
            ],
            [
                'required' => ':attribute wajib diisi',
            ]
        );

        $classLearn = ClassLearn::where('class_room_id', $request->class_room_id)
                        ->where('subject_id', $request->subject_id)
                        ->first();

        if ($classLearn != null) {
            return redirect('/class-learns/create')
                ->with('error', 'Data kelas ajar sudah ada!')
                ->withInput();
        }

        ClassLearn::create($request->all());
        return redirect('/class-learns')->with('status', 'Data kelas ajar berhasil ditambah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassLearn $classLearn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassLearn $classLearn)
    {
        $classes   = ClassRoom::all();
        $teachers  = \App\Teacher::all();
        $semesters = \App\Semester::all();
        $subjects  = \App\Subject::all();
        return view('kelas_ajar.edit', compact('classLearn', 'teachers', 'semesters', 'subjects', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClassLearn $classLearn)
    {
        $class = ClassLearn::where('class_room_id', $request->class_room_id)
                    ->where('subject_id', $request->subject_id)
                    ->first();

        if ($class && $class->id != $classLearn->id) {
            return redirect('class-learns/' . $classLearn->id . '/edit')
                ->with('error', 'Data kelas ajar sudah ada!')
                ->withInput();
        }

        $classLearn = ClassLearn::find($classLearn->id);
        $classLearn->update($request->all());
        $classLearn->save();
        return redirect('/class-learns');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClassLearn $classLearn)
    {
        ClassLearn::destroy($classLearn->id);
        return redirect('/class-learns')->with('status', 'Data berhasil dihapus!');
    }

    /**
     * DataTables AJAX — dengan null safety pada semua relasi
     */
    public function getdataclassLearn()
    {
        // Eager load relasi agar tidak N+1 query dan bisa dicek null-nya
        $classLearns = ClassLearn::with(['classRoom', 'subject'])
                        ->select('class_learns.*')
                        ->orderBy('class_room_id', 'asc');

        return \DataTables::eloquent($classLearns)
            ->addIndexColumn()
            ->addColumn('kelas', function ($cl) {
                // Cek null sebelum akses ->nama
                return $cl->classRoom ? $cl->classRoom->nama : '<span class="text-danger">Kelas dihapus</span>';
            })
            ->addColumn('mapel', function ($cl) {
                // Cek null sebelum akses ->nama
                return $cl->subject ? $cl->subject->nama : '<span class="text-danger">Mapel dihapus</span>';
            })
            ->addColumn('aksi', function ($cl) {
                return '
                <a href="/class-learns/' . $cl->id . '/edit" class="btn btn-warning btn-sm">edit</a>
                <form action="/class-learns/' . $cl->id . '" method="post" class="d-inline delete">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger delete btn-sm">hapus</button>
                </form>';
            })
            ->rawColumns(['aksi', 'kelas', 'mapel'])
            ->toJson();
    }
}