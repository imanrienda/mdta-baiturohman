@extends('layouts/master')

@section('title', 'Ubah Nilai')
@section('header', 'Ubah Data Nilai')

@section('content')

<div class="row">
   <div class="col-md-12">

      <div class="card card-success">

         <div class="card-header">
            <h3 class="card-title">Ubah Data Nilai</h3>
         </div>

         <form method="post" action="/teacher/grades/{{ $grade->id }}" role="form">
            @csrf
            @method('PUT')

            <div class="card-body">

               {{-- HIDDEN INPUT --}}
               <input type="hidden" name="class_room_id" value="{{ $grade->class_room_id }}">
               <input type="hidden" name="semester_id" value="{{ $grade->semester_id }}">
               <input type="hidden" name="student_id" value="{{ $grade->student_id }}">
               <input type="hidden" name="subject_id" value="{{ $grade->subject_id }}">

               {{-- DATA SISWA --}}
               <div class="form-row">

                  <div class="form-group col-md-6">
                     <label>Nama Siswa</label>

                     <input
                        type="text"
                        class="form-control"
                        value="{{ $grade->student->nama ?? '-' }}"
                        readonly
                     >
                  </div>

                  <div class="form-group col-md-6">
                     <label>Kelas</label>

                     <input
                        type="text"
                        class="form-control"
                        value="{{ $grade->classRoom->nama ?? '-' }}"
                        readonly
                     >
                  </div>

               </div>

               {{-- MATA PELAJARAN --}}
               <div class="form-group">
                  <label>Mata Pelajaran</label>

                  <input
                     type="text"
                     class="form-control"
                     value="{{ $grade->subject->nama ?? '-' }}"
                     readonly
                  >
               </div>

               {{-- NILAI --}}
               <div class="form-row">

                  <div class="form-group col-md-6">
                     <label>Nilai Tugas 1</label>

                     <input
                        type="number"
                        class="form-control"
                        name="nilai_tugas_1"
                        value="{{ $grade->nilai_tugas_1 }}"
                        required
                     >
                  </div>

                  <div class="form-group col-md-6">
                     <label>Nilai Tugas 2</label>

                     <input
                        type="number"
                        class="form-control"
                        name="nilai_tugas_2"
                        value="{{ $grade->nilai_tugas_2 }}"
                        required
                     >
                  </div>

               </div>

               <div class="form-row">

                  <div class="form-group col-md-6">
                     <label>Nilai UTS</label>

                     <input
                        type="number"
                        class="form-control"
                        name="nilai_uts"
                        value="{{ $grade->nilai_uts }}"
                        required
                     >
                  </div>

                  <div class="form-group col-md-6">
                     <label>Nilai UAS</label>

                     <input
                        type="number"
                        class="form-control"
                        name="nilai_uas"
                        value="{{ $grade->nilai_uas }}"
                        required
                     >
                  </div>

               </div>

            </div>

            {{-- FOOTER --}}
            <div class="card-footer">

               <button type="submit" class="btn btn-success">
                  Ubah Data
               </button>

               <a
                  href="/teacher/grades?kelas={{ $grade->class_room_id }}&semester={{ $grade->semester_id }}"
                  class="btn btn-warning"
               >
                  Batal
               </a>

            </div>

         </form>

      </div>

   </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/script-input-edit.js') }}"></script>
@endsection