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

         <form method="post" action="/grades/{{ $grade->id }}" role="form">
            @csrf
            @method('PUT')

            <div class="card-body">

               {{-- ========================================= --}}
               {{-- HIDDEN INPUT --}}
               {{-- ========================================= --}}

               <input type="hidden"
                  name="class_student_id"
                  value="{{ $grade->class_student_id }}">

               <input type="hidden"
                  name="student_id"
                  value="{{ $grade->student_id }}">

               <input type="hidden"
                  name="semester_id"
                  value="{{ $grade->semester_id }}">

               <input type="hidden"
                  name="class_learn_id"
                  value="{{ $grade->class_learn_id }}">

               {{-- ========================================= --}}
               {{-- DATA SISWA --}}
               {{-- ========================================= --}}

               <div class="form-row">

                  <div class="form-group col-md-6">
                     <label>Nama Siswa</label>

                     <input
                        type="text"
                        class="form-control"
                        value="{{ $grade->classStudent->student->nama ?? '-' }}"
                        readonly>
                  </div>

                  <div class="form-group col-md-6">
                     <label>Kelas</label>

                     <input
                        type="text"
                        class="form-control"
                        value="{{ $grade->classStudent->classRoom->nama ?? '-' }}"
                        readonly>
                  </div>

               </div>

               {{-- ========================================= --}}
               {{-- MAPEL --}}
               {{-- ========================================= --}}

               <div class="form-group">

                  <label>Mata Pelajaran</label>

                  <input
                     type="text"
                     class="form-control"
                     value="{{ $grade->subject->nama ?? '-' }}"
                     readonly>

               </div>

               {{-- ========================================= --}}
               {{-- NILAI --}}
               {{-- ========================================= --}}

               <div class="form-row">

                  <div class="form-group col-md-6">

                     <label>Nilai Tugas 1</label>

                     <input
                        type="number"
                        min="0"
                        max="100"
                        class="form-control @error('nilai_tugas_1') is-invalid @enderror"
                        name="nilai_tugas_1"
                        value="{{ old('nilai_tugas_1', $grade->nilai_tugas_1) }}"
                        required>

                     @error('nilai_tugas_1')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                     @enderror

                  </div>

                  <div class="form-group col-md-6">

                     <label>Nilai Tugas 2</label>

                     <input
                        type="number"
                        min="0"
                        max="100"
                        class="form-control @error('nilai_tugas_2') is-invalid @enderror"
                        name="nilai_tugas_2"
                        value="{{ old('nilai_tugas_2', $grade->nilai_tugas_2) }}"
                        required>

                     @error('nilai_tugas_2')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                     @enderror

                  </div>

               </div>

               <div class="form-row">

                  <div class="form-group col-md-6">

                     <label>Nilai UTS</label>

                     <input
                        type="number"
                        min="0"
                        max="100"
                        class="form-control @error('nilai_uts') is-invalid @enderror"
                        name="nilai_uts"
                        value="{{ old('nilai_uts', $grade->nilai_uts) }}"
                        required>

                     @error('nilai_uts')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                     @enderror

                  </div>

                  <div class="form-group col-md-6">

                     <label>Nilai UAS</label>

                     <input
                        type="number"
                        min="0"
                        max="100"
                        class="form-control @error('nilai_uas') is-invalid @enderror"
                        name="nilai_uas"
                        value="{{ old('nilai_uas', $grade->nilai_uas) }}"
                        required>

                     @error('nilai_uas')
                        <div class="invalid-feedback">
                           {{ $message }}
                        </div>
                     @enderror

                  </div>

               </div>

            </div>

            {{-- ========================================= --}}
            {{-- FOOTER --}}
            {{-- ========================================= --}}

            <div class="card-footer">

               <button type="submit" class="btn btn-success">
                  Ubah Data
               </button>

               <a
                  href="/grades?kelas={{ $grade->classStudent->class_room_id ?? '' }}&semester={{ $grade->semester_id }}"
                  class="btn btn-warning">
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