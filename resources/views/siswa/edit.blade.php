@extends('layouts/master')

@section('title', 'Ubah Siswa')
@section('header', 'Ubah Data Siswa')

@section('content')

<div class="row">
   <div class="col-md-6">

      <div class="card card-primary">

         <div class="card-header">
            <h3 class="card-title">
               Ubah Data Siswa
            </h3>
         </div>

         <form
            method="post"
            action="/students/{{$student->id}}"
            role="form"
            enctype="multipart/form-data">

            @csrf
            @method('put')

            <div class="card-body">

               {{-- NIS --}}
               <div class="form-group">

                  <label for="nis">
                     NIS
                  </label>

                  <input
                     type="text"
                     name="nis"
                     class="form-control @error('nis') is-invalid @enderror"
                     id="nis"
                     value="{{ old('nis', $student->nis) }}"
                     placeholder="Masukkan NIS">

                  @error('nis')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Nama --}}
               <div class="form-group">

                  <label for="nama">
                     Nama
                  </label>

                  <input
                     type="text"
                     name="nama"
                     class="form-control @error('nama') is-invalid @enderror"
                     id="nama"
                     value="{{ old('nama', $student->nama) }}"
                     placeholder="Masukkan Nama">

                  @error('nama')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Tempat Lahir --}}
               <div class="form-group">

                  <label for="tempat_lahir">
                     Tempat Lahir
                  </label>

                  <input
                     type="text"
                     name="tempat_lahir"
                     class="form-control @error('tempat_lahir') is-invalid @enderror"
                     id="tempat_lahir"
                     value="{{ old('tempat_lahir', $student->tempat_lahir) }}"
                     placeholder="Masukkan Tempat Lahir">

                  @error('tempat_lahir')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Tanggal Lahir --}}
               <div class="form-group">

                  <label for="tanggal_lahir">
                     Tanggal Lahir
                  </label>

                  <div class="input-group">

                     <div class="input-group-prepend">
                        <span class="input-group-text">
                           <i class="far fa-calendar-alt"></i>
                        </span>
                     </div>

                     <input
                        type="text"
                        name="tanggal_lahir"
                        class="form-control float-right @error('tanggal_lahir') is-invalid @enderror"
                        id="tanggal_lahir"
                        value="{{ old('tanggal_lahir', optional($student->tanggal_lahir)->format('Y-m-d')) }}">

                  </div>

                  @error('tanggal_lahir')
                     <div class="invalid-feedback d-block">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Jenis Kelamin --}}
               <div class="form-group">

                  <label for="jenis_kelamin">
                     Jenis Kelamin
                  </label>

                  <select
                     class="form-control custom-select @error('jenis_kelamin') is-invalid @enderror"
                     id="jenis_kelamin"
                     name="jenis_kelamin">

                     <option value="" disabled>
                        Pilih Jenis Kelamin
                     </option>

                     <option
                        value="Laki-laki"
                        {{ old('jenis_kelamin', $student->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                        Laki-laki
                     </option>

                     <option
                        value="Perempuan"
                        {{ old('jenis_kelamin', $student->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                        Perempuan
                     </option>

                  </select>

                  @error('jenis_kelamin')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Agama --}}
               <div class="form-group">

                  <label for="agama">
                     Agama
                  </label>

                  <select
                     class="form-control custom-select @error('agama') is-invalid @enderror"
                     id="agama"
                     name="agama">

                     <option value="" disabled>
                        Pilih Agama
                     </option>

                     <option value="Islam"
                        {{ old('agama', $student->agama) == 'Islam' ? 'selected' : '' }}>
                        Islam
                     </option>

                     <option value="Kristen"
                        {{ old('agama', $student->agama) == 'Kristen' ? 'selected' : '' }}>
                        Kristen
                     </option>

                     <option value="Katolik"
                        {{ old('agama', $student->agama) == 'Katolik' ? 'selected' : '' }}>
                        Katolik
                     </option>

                     <option value="Budha"
                        {{ old('agama', $student->agama) == 'Budha' ? 'selected' : '' }}>
                        Budha
                     </option>

                     <option value="Hindu"
                        {{ old('agama', $student->agama) == 'Hindu' ? 'selected' : '' }}>
                        Hindu
                     </option>

                  </select>

                  @error('agama')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Alamat --}}
               <div class="form-group">

                  <label for="alamat">
                     Alamat
                  </label>

                  <textarea
                     name="alamat"
                     class="form-control @error('alamat') is-invalid @enderror"
                     id="alamat"
                     rows="4"
                     placeholder="Masukkan alamat">{{ old('alamat', $student->alamat) }}</textarea>

                  @error('alamat')
                     <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                  @enderror

               </div>

               {{-- Foto --}}
               <div class="form-group">

                  <label for="foto">
                     Foto
                  </label>

                  <div class="mb-2">

                     <img
                        src="{{ $student->getFoto() }}"
                        alt="Foto Siswa"
                        id="foto-preview"
                        class="img-thumbnail"
                        style="max-height: 150px; display:block;">

                  </div>

                  <input
                     type="file"
                     name="foto"
                     class="form-control-file @error('foto') is-invalid @enderror"
                     id="foto"
                     accept="image/jpeg,image/png,image/jpg"
                     onchange="previewFoto(this)">

                  @error('foto')
                     <div class="invalid-feedback d-block">
                        {{ $message }}
                     </div>
                  @enderror

                  <small class="text-muted">
                     Kosongkan jika tidak ingin mengubah foto.
                     Format: JPG, JPEG, PNG.
                  </small>

               </div>

            </div>

            <div class="card-footer">

               <button type="submit" class="btn btn-primary">
                  Ubah Data
               </button>

               <a
                  href="{{ url()->previous() }}"
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

<script>

   function previewFoto(input)
   {
      if (input.files && input.files[0])
      {
         var reader = new FileReader();

         reader.onload = function(e)
         {
            document.getElementById('foto-preview').src = e.target.result;
         }

         reader.readAsDataURL(input.files[0]);
      }
   }

</script>

@endsection