@extends('layouts/master')

@section('title', 'Kelas Siswa')
@section('header', 'Data Kelas Siswa')

@section('content')

<div class="row">
   <div class="col-lg">
      <form action="/class-students" method="get">
         <div class="row">
            <div class="col-auto">
               <div class="form-group">
                  <select name="semester" id="semester" class="form-control" required>
                     <option value="">Pilih tahun ajaran</option>
                     @foreach ($semesters->unique('tahun_ajaran') as $semester)
                     <option value="{{$semester->id}}" {{ ($_GET) ? $_GET['semester'] == $semester->id ? 'selected' : '' : '' }}>
                        {{ $semester->tahun_ajaran  }}
                     </option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-auto">
               <button type="submit" class="btn btn-success">Tampilkan</button>
            </div>
         </div>
      </form>


      @if(isset($_GET['semester']))

      <div class="row">
         @foreach ($classes as $cs)
         @php
         $students = \App\ClassStudent::where('class_room_id', $cs->id)->where('semester_id', $_GET['semester'])->get();
         @endphp

         <div class="col-md-6">
            <div class="card">
               <div class="card-header">
                  <div class="card-title">
                     Data Kelas {{ $cs->nama }}
                  </div>
               </div>

               <div class="card-body">

                  <a href="" class="btn btn-primary btn-sm mb-3 tambah" data-toggle="modal" data-target="#exampleModal"
                     data-id="{{ $cs->id }}" data-class="Kelas {{ $cs->nama }}">Tambah</a>

                  <table class="table table-bordered table-striped" id="datatable{{ $cs->id}}">
                     <thead>
                        <tr>
                           <th>No</th>
                           <th class="col-6">Nama</th>
                           <th class="col-3">Aksi</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($students as $item)
                        <tr>
                           <td>{{ $loop->iteration }}</td>
                           <td>{{ isset($item->student->nama) ? ucfirst($item->student->nama) : 'no first name!' }}</td>
                           <td>
                              <form action="/class-students/{{ $item->id }}" method="post" class="d-inline s">
                                 @csrf
                                 @method('delete')
                                 <button type="submit" class="btn btn-danger btn-sm">hapus</button>
                              </form>
                           </td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
         @endforeach
      </div>

      @else
      <div class="alert alert-info">
         Untuk menampilkan jadwal pilih kelas dan semester
      </div>
      @endif
   </div>
</div>


<!-- Modal -->
@if(isset($_GET['semester']))
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form action="/class-student-by-student" method="post">
               @csrf
               <div class="custom-control custom-checkbox mb-3">
                  <input type="checkbox" class="custom-control-input" id="selectAll">
                  <label class="custom-control-label" for="selectAll">Pilih Semua</label>
               </div>
               <table class="table" id="modalTable">
                  <thead>
                     <tr>
                        <th>Nama</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($studentNotExists as $sne)
                     <tr>
                        <td>
                           <div class="custom-control custom-checkbox">
                              <input type="checkbox" class="custom-control-input" id="student_id{{$sne->id}}"
                                 name="student_id[]" value="{{$sne->id}}">
                              <label class="custom-control-label" for="student_id{{$sne->id}}">{{$sne->nama}}</label>
                           </div>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>

               <input type="hidden" id="class_room_id" name="class_room_id" value="" />
               <input type="hidden" id="d" name="semester_id" value="{{ $_GET['semester'] }}" />
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
         </div>
         </form>
      </div>
   </div>
</div>
@endif

@endsection

@section('script')
<script>
   $(document).ready(function(){
      $("table[id^='datatable']").DataTable({
         "pageLength": 50
      });

      $("#modalTable").DataTable({
         "pageLength": 50
      });

      $(".tambah").click(function(){
         var id = $(this).attr('data-id');
         $("#class_room_id").val(id);

         var classRoom = $(this).attr('data-class')
         $(".modal-title").html(classRoom);
      });

      $("#selectAll").click(function () {
         $('input:checkbox').not(this).prop('checked', this.checked);
      });
   });

   $('.s').submit(function(e) {
      if(confirm('Do you really want to submit the form?')) {
         return true;
      }
      return false;
   });
</script>
@endsection