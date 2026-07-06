@extends('layouts/master')

@section('title', 'Siswa')
@section('header', 'Data Siswa')

@section('content')

<div class="row">
   <div class="col-md-12">
      <div class="d-flex align-items-center mb-3 gap-2 flex-wrap">
         <a href="/students/create" class="btn btn-primary coba load">Tambah Siswa</a>

         <form action="/export-siswa-pdf" method="GET" class="d-inline-flex align-items-center gap-2">
            <select name="semester_id" class="form-control w-auto" required>
               <option value="">-- Pilih Semester --</option>
               @foreach($semesters as $sem)
                  <option value="{{ $sem->id }}">
                     {{ $sem->tahun_ajaran }} | {{ $sem->semester }}
                  </option>
               @endforeach
            </select>
            <button type="submit" class="btn btn-danger">Export PDF</button>
         </form>
      </div>

      <div class="card">
         <div class="card-header">
            <div class="card-title">
               Data Siswa
            </div>
         </div>
         <div class="card-body">
            <table class="table" id="datatable">
               <thead>
                  <tr>
                     <th>No</th>
                     <th>Nama</th>
                     <th>NISN</th>
                     <th>Jenis Kelamin</th>
                     <th>Semester</th>
                     <th>Alamat</th>
                     <th>Aksi</th>
                  </tr>
               </thead>
               <tbody>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection

@section('script')
<script>
   $(document).ready(function(){
      $('#datatable').DataTable({
         processing: true,
         serverside: true,
         ajax: "{{ route('ajax.get.data.student') }}",
         columns:[
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nama', name: 'nama' },
            { data: 'nis', name: 'nis' },
            { data: 'jenis_kelamin', name: 'jenis_kelamin' },
            { data: 'semester', name: 'semester', orderable: false, searchable: false },
            { data: 'alamat', name: 'alamat' },
            { data: 'aksi', name: 'aksi' },
         ]
      });

      $('#datatable').on('click', '.delete', function(e) {
         e.preventDefault();
         const form = $(this).closest('form');

         Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Data siswa dan user ini akan hilang!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
         }).then((result) => {
            if (result.value) {
               form.submit();
            }
         });
      });
   });
</script>
@endsection