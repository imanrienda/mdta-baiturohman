@extends('layouts/master')

@section('title', 'Tambah Nilai')
@section('header', 'Tambah Data Nilai')

@section('content')

<div class="row">
   <div class="col-md-12">

      <div class="card card-primary">

         <div class="card-header">
            <h3 class="card-title">
               Input Data Nilai {{ $class->nama ?? '-' }}
            </h3>
         </div>

         {{-- FORM GENERATE MAPEL --}}
         <form action="/teacher/grades/{{$class->id}}/{{$semester->id}}/create"
               method="get"
               class="ml-3 mt-3">

            <div class="row">

               <div class="col-md-4">

                  <div class="input-group mb-3">

                     <select name="subject"
                             id="subject"
                             class="form-control"
                             required>

                        <option value="">
                           Pilih mata pelajaran
                        </option>

                        @foreach ($schedule->unique('subject_id') as $s)

                           @if($s->subject)

                              <option value="{{ $s->subject_id }}"
                                 {{ request('subject') == $s->subject_id ? 'selected' : '' }}>

                                 {{ $s->subject->nama }}

                              </option>

                           @endif

                        @endforeach

                     </select>

                     <div class="input-group-append">
                        <button type="submit" class="btn btn-success">
                           Generate
                        </button>
                     </div>

                  </div>

               </div>

            </div>

         </form>

         {{-- FORM INPUT NILAI --}}
         @if(request()->filled('subject'))

            <form method="POST"
                  action="/teacher/grades"
                  role="form">

               @csrf

               <div class="card-body">

                  @if(isset($students) && $students->count() > 0)

                     <table class="table table-bordered table-hover">

                        <thead class="thead-light">
                           <tr>
                              <th width="60">No</th>
                              <th>Nama Siswa</th>
                              <th width="140">Tugas 1</th>
                              <th width="140">Tugas 2</th>
                              <th width="140">UTS</th>
                              <th width="140">UAS</th>
                           </tr>
                        </thead>

                        <tbody>

                           @foreach ($students as $student)

                              <tr>

                                 {{-- HIDDEN INPUT --}}
                                 <input type="hidden"
                                        name="class_room_id[]"
                                        value="{{ $class->id }}">

                                 <input type="hidden"
                                        name="semester_id[]"
                                        value="{{ $semester->id }}">

                                 <input type="hidden"
                                        name="class_student_id[]"
                                        value="{{ $student->id }}">

                                 <input type="hidden"
                                        name="teacher_id[]"
                                        value="{{ auth()->user()->teacher->id }}">

                                 <input type="hidden"
                                        name="student_id[]"
                                        value="{{ $student->student_id }}">

                                 <input type="hidden"
                                        name="subject_id"
                                        value="{{ request('subject') }}">

                                 <td>
                                    {{ $loop->iteration }}
                                 </td>

                                 <td>
                                    {{ $student->nama }}
                                 </td>

                                 <td>
                                    <input type="number"
                                           class="form-control"
                                           name="nilai_tugas_1[]"
                                           min="0"
                                           max="100"
                                           required>
                                 </td>

                                 <td>
                                    <input type="number"
                                           class="form-control"
                                           name="nilai_tugas_2[]"
                                           min="0"
                                           max="100"
                                           required>
                                 </td>

                                 <td>
                                    <input type="number"
                                           class="form-control"
                                           name="nilai_uts[]"
                                           min="0"
                                           max="100"
                                           required>
                                 </td>

                                 <td>
                                    <input type="number"
                                           class="form-control"
                                           name="nilai_uas[]"
                                           min="0"
                                           max="100"
                                           required>
                                 </td>

                              </tr>

                           @endforeach

                        </tbody>

                     </table>

                  @else

                     <div class="alert alert-warning">
                        Semua siswa sudah memiliki nilai pada mata pelajaran ini.
                     </div>

                  @endif

               </div>

               @if(isset($students) && $students->count() > 0)

                  <div class="card-footer">

                     <button type="submit"
                             class="btn btn-primary">

                        Tambah Data

                     </button>

                     <a href="/teacher/grades?kelas={{ $class->id }}&semester={{ $semester->id }}"
                        class="btn btn-warning">

                        Batal

                     </a>

                  </div>

               @endif

            </form>

         @endif

      </div>

   </div>
</div>

@endsection

@section('script')

<script src="{{ asset('assets/js/script-input-edit.js') }}"></script>

@endsection