@extends('layouts/master')
@section('title', 'Pengumuman')
@section('header', 'Data Pengumuman')
@section('content')
<div class="row">
   <div class="col-md-12">
      <a href="informations/create" class="btn btn-primary mb-3 coba">Tambah Pengumuman</a>
      <div class="card">
         <div class="card-header">
            <div class="card-title">
               Data Pengumuman
            </div>
         </div>
         <div class="card-body">
            <table class="table" id="datatable">
               <thead>
                  <tr>
                     <th>No</th>
                     <th>Judul</th>
                     <th>Aktif</th>
                     {{-- <th>Konten</th> --}}
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
         serverSide: true,
         // FIX: Set default order ke kolom ke-2 (index 1 = judul)
         // Kolom ke-1 (index 0 = DT_RowIndex) adalah kolom virtual, tidak bisa di-sort MySQL
         order: [[1, 'asc']],
         ajax: "{{ route('ajax.get.data.information') }}",
         columns:[
            // FIX: orderable: false pada DT_RowIndex agar tidak bisa di-klik untuk sort
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'judul', name: 'judul'},
            {data: 'publish', name: 'publish'},
            // {data: 'konten', name: 'konten'},
            {data: 'aksi', name: 'aksi', orderable: false, searchable: false},
         ]
      });

      $('#datatable').on('click', 'button.delete', function(e) {
         e.preventDefault();
         const $form = $(this).closest('form.delete');
         Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Data pengumuman ini akan hilang!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
         }).then((result) => {
            if (result.value) {
               $form.submit();
            }
         });
      });
   });
</script>
@endsection