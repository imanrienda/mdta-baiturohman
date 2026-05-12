@extends('layouts/master')

@section('title', 'Tambah Nilai')
@section('header', 'Tambah Data Nilai')

@section('content')

<div class="row">
   <div class="col-md-12">

      <div class="card card-primary">

         <div class="card-header">
            <h3 class="card-title">
               Input Data Nilai {{ $class->nama }}
            </h3>
         </div>

         {{-- FORM GENERATE --}}
         <form action="/grades/{{$class->id}}/{{$semester->id}}/create" method="get" class="ml-3 mt-3">

            <div class="row">

               <div class="col-md-3">

                  <div class="input-group mb-3">

                     <select
                        name="subject"
                        id="subject_id"
                        class="form-control"
                        required>

                        <option value="">
                           Pilih mata pelajaran
                        </option>

                        @foreach ($schedule->unique('subject_id') as $cl)

                           <option
                              value="{{ $cl->subject_id }}"
                              {{ isset($_GET['subject']) && $_GET['subject'] == $cl->subject_id ? 'selected' : '' }}>

                              {{ $cl->subject->nama ?? '-' }}

                           </option>

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
         @if(isset($_GET['subject']))

         <form method="post" action="/grades" role="form">

            @csrf

            <div class="card-body">

               <table class="table table-bordered">

                  <thead>

                     <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Nilai Tugas 1</th>
                        <th>Nilai Tugas 2</th>
                        <th>Nilai UTS</th>
                        <th>Nilai UAS</th>
                     </tr>

                  </thead>

                  <tbody>

                     @foreach ($students as $s)

                     @php

                        $scheduleData = \App\Schedule::where('subject_id', $_GET['subject'])
                                          ->where('class_room_id', $class->id)
                                          ->first();

                     @endphp

                     <tr>

                        <td>
                           {{ $loop->iteration }}
                        </td>

                        <td>
                           {{ $s->nama }}
                        </td>

                        {{-- HIDDEN INPUT --}}
                        <input
                           type="hidden"
                           name="class_room_id[]"
                           value="{{ $class->id }}">

                        <input
                           type="hidden"
                           name="semester_id[]"
                           value="{{ $semester->id }}">

                        <input
                           type="hidden"
                           name="class_student_id[]"
                           value="{{ $s->id }}">

                        <input
                           type="hidden"
                           name="teacher_id[]"
                           value="{{ $scheduleData->teacher_id ?? '' }}">

                        <input
                           type="hidden"
                           name="class_learn_id[]"
                           value="{{ $scheduleData->class_learn_id ?? '' }}">

                        <input
                           type="hidden"
                           name="student_id[]"
                           value="{{ $s->student_id }}">

                        <input
                           type="hidden"
                           name="subject_id"
                           value="{{ $_GET['subject'] }}">

                        {{-- NILAI --}}
                        <td>

                           <input
                              type="number"
                              class="form-control"
                              name="nilai_tugas_1[]"
                              min="0"
                              max="100"
                              required>

                        </td>

                        <td>

                           <input
                              type="number"
                              class="form-control"
                              name="nilai_tugas_2[]"
                              min="0"
                              max="100"
                              required>

                        </td>

                        <td>

                           <input
                              type="number"
                              class="form-control"
                              name="nilai_uts[]"
                              min="0"
                              max="100"
                              required>

                        </td>

                        <td>

                           <input
                              type="number"
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

            </div>

            <div class="card-footer">

               <button type="submit" class="btn btn-primary">
                  Tambah Data
               </button>

               <a
                  href="/grades?kelas={{ $class->id }}&semester={{ $semester->id }}"
                  class="btn btn-warning">

                  Batal

               </a>

            </div>

         </form>

         @endif

      </div>

   </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/script-input-edit.js') }}"></script>
@endsection