@extends('layouts/master')

@section('title', 'Tambah Jadwal Kelas')
@section('header', 'Tambah Data Jadwal Kelas')

@section('content')

<div class="row">
   <div class="col-md-6">
      <div class="card card-warning">

         <div class="card-header">
            <h3 class="card-title">
               Input Data Jadwal Kelas
               {{ optional(optional($classStudent)->classRoom)->nama ?? '-' }}
            </h3>
         </div>

         <form method="post" action="/schedules" role="form">
            @csrf

            <div class="card-body">

               @if (session('error'))
                  <div class="alert alert-danger">
                     {{ session('error') }}
                  </div>
               @endif

               {{-- Kode Kelas --}}
               <div class="form-row">

                  <div class="form-group col-md-6">
                     <label>Kode Kelas</label>

                     <input
                        type="text"
                        class="form-control"
                        value="{{ optional(optional($classStudent)->classRoom)->kode_kelas }}"
                        readonly>
                  </div>

                  <div class="form-group col-md-6">
                     <label>Nama Kelas</label>

                     <input
                        type="text"
                        class="form-control"
                        value="{{ optional(optional($classStudent)->classRoom)->nama }}"
                        readonly>
                  </div>

               </div>

               {{-- Semester --}}
               <div class="form-group">
                  <label>Semester</label>

                  <input
                     type="text"
                     class="form-control"
                     value="{{ $semester->tahun_ajaran . ' | ' . $semester->semester }}"
                     disabled>
               </div>

               {{-- Hari --}}
               <div class="form-group">

                  <label>Hari</label>

                  <select
                     class="form-control custom-select @error('hari') is-invalid @enderror"
                     name="hari">

                     <option value="" selected disabled>
                        Pilih hari...
                     </option>

                     @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)

                        <option
                           value="{{ $hari }}"
                           {{ old('hari') == $hari ? 'selected' : '' }}>

                           {{ $hari }}

                        </option>

                     @endforeach

                  </select>

                  @error('hari')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Jam Mulai --}}
               <div class="form-group">

                  <label>Jam Mulai</label>

                  <input
                     type="text"
                     name="jam_mulai"
                     class="form-control jam @error('jam_mulai') is-invalid @enderror"
                     value="{{ old('jam_mulai') }}"
                     placeholder="Contoh: 08:00">

                  @error('jam_mulai')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Jam Selesai --}}
               <div class="form-group">

                  <label>Jam Selesai</label>

                  <input
                     type="text"
                     name="jam_selesai"
                     class="form-control jam @error('jam_selesai') is-invalid @enderror"
                     value="{{ old('jam_selesai') }}"
                     placeholder="Contoh: 10:00">

                  @error('jam_selesai')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Hidden --}}
               <input
                  type="hidden"
                  name="class_room_id"
                  value="{{ optional($classStudent)->class_room_id }}">

               <input
                  type="hidden"
                  name="semester_id"
                  value="{{ $semester->id }}">

               {{-- Mata Pelajaran --}}
               <div class="form-group">

                  <label>Mata Pelajaran</label>

                  <select
                     name="subject_id"
                     class="form-control custom-select @error('subject_id') is-invalid @enderror">

                     <option value="" selected disabled>
                        Pilih mata pelajaran...
                     </option>

                     @foreach ($subjects as $subject)

                        <option
                           value="{{ $subject->id }}"
                           {{ old('subject_id') == $subject->id ? 'selected' : '' }}>

                           {{ $subject->nama }}

                        </option>

                     @endforeach

                  </select>

                  @error('subject_id')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Guru --}}
               <div class="form-group">

                  <label>Guru</label>

                  <select
                     class="form-control custom-select @error('teacher_id') is-invalid @enderror"
                     name="teacher_id">

                     <option value="" selected disabled>
                        Pilih guru...
                     </option>

                     @php
                        $teachers = \App\Teacher::all();
                     @endphp

                     @foreach ($teachers as $teacher)

                        <option
                           value="{{ $teacher->id }}"
                           {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>

                           {{ $teacher->nama }}

                        </option>

                     @endforeach

                  </select>

                  @error('teacher_id')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

            </div>

            <div class="card-footer">

               <button type="submit" class="btn btn-primary">
                  Tambah Data
               </button>

               <a
                  href="/schedules?kelas={{ optional($classStudent)->class_room_id }}&semester={{ $semester->id }}"
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