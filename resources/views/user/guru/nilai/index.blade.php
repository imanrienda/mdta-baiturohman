@extends('layouts/master')

@section('title', 'Nilai')
@section('header', 'Data Nilai')

@section('content')

<div class="row">
   <div class="col-lg">

      {{-- FORM FILTER --}}
      <form action="/teacher/grades" method="get">
         <div class="row">

            {{-- PILIH KELAS --}}
            <div class="col-auto">
               <div class="form-group">
                  <select name="kelas" id="kelas" class="form-control" required>

                     <option value="">Pilih kelas</option>

                     {{-- ========================================= --}}
                     {{-- FIX RELASI BARU --}}
                     {{-- ========================================= --}}
                     @foreach ($classes->unique('class_room_id') as $class)

                        @if($class->classRoom)

                           <option value="{{ $class->class_room_id }}"
                              {{ isset($_GET['kelas']) && $_GET['kelas'] == $class->class_room_id ? 'selected' : '' }}>

                              {{ $class->classRoom->nama }}

                           </option>

                        @endif

                     @endforeach

                  </select>
               </div>
            </div>

            {{-- PILIH SEMESTER --}}
            <div class="col-auto">
               <div class="form-group">

                  <select name="semester" id="semester" class="form-control" required>

                     <option value="">Pilih semester</option>

                     @foreach ($semesters as $semester)

                        <option value="{{ $semester->id }}"
                           {{ isset($_GET['semester']) && $_GET['semester'] == $semester->id ? 'selected' : '' }}>

                           {{ $semester->tahun_ajaran . ' | ' . $semester->semester }}

                        </option>

                     @endforeach

                  </select>

               </div>
            </div>

            <div class="col-auto">
               <button type="submit" class="btn btn-success">
                  Tampilkan
               </button>
            </div>

         </div>
      </form>

      {{-- ALERT --}}
      @if(session('status'))

         <div class="alert alert-success mt-3">
            {{ session('status') }}
         </div>

      @endif

      {{-- ========================================= --}}
      {{-- TABEL NILAI --}}
      {{-- ========================================= --}}
      @if(isset($_GET['kelas']) && isset($_GET['semester']))

         <div class="card mt-3">

            <div class="card-header">
               <div class="card-title">

                  Data Nilai Kelas
                  {{ $classSelected->nama ?? '-' }}

               </div>
            </div>

            <div class="card-body">

               <a href="/teacher/grades/{{ $_GET['kelas'] }}/{{ $_GET['semester'] }}/create"
                  class="btn btn-primary btn-sm mb-3">

                  Tambah Nilai

               </a>

               @if(isset($grades) && $grades->isNotEmpty())

                  <table class="table table-bordered table-hover" id="datatable">

                     <thead class="thead-light">
                        <tr>
                           <th>No</th>
                           <th>Nama Siswa</th>
                           <th>Mata Pelajaran</th>
                           <th>Nilai Tugas 1</th>
                           <th>Nilai Tugas 2</th>
                           <th>Nilai UTS</th>
                           <th>Nilai UAS</th>
                           <th>Rata-rata</th>
                           <th>Semester</th>
                           <th>Aksi</th>
                        </tr>
                     </thead>

                     <tbody>

                        @foreach ($grades as $grade)

                           <tr>

                              <td>{{ $loop->iteration }}</td>

                              <td>
                                 {{ $grade->classStudent->student->nama ?? '-' }}
                              </td>

                              {{-- ========================================= --}}
                              {{-- FIX RELASI BARU --}}
                              {{-- ========================================= --}}
                              <td>
                                 {{ $grade->subject->nama ?? '-' }}
                              </td>

                              <td>{{ $grade->nilai_tugas_1 }}</td>

                              <td>{{ $grade->nilai_tugas_2 }}</td>

                              <td>{{ $grade->nilai_uts }}</td>

                              <td>{{ $grade->nilai_uas }}</td>

                              <td>
                                 {{ isset($grade->rata2) ? number_format($grade->rata2, 2) : '-' }}
                              </td>

                              <td>
                                 {{ $grade->semester->semester ?? '-' }}
                              </td>

                              <td>

                                 <a href="/teacher/grades/{{ $grade->id }}/edit"
                                    class="btn btn-warning btn-sm">

                                    Edit

                                 </a>

                              </td>

                           </tr>

                        @endforeach

                     </tbody>

                  </table>

               @else

                  <div class="alert alert-warning">

                     Data nilai tidak ada untuk kelas dan semester yang dipilih.

                  </div>

               @endif

            </div>

         </div>

      @else

         <div class="alert alert-info mt-3">

            Untuk menampilkan nilai, pilih kelas dan semester terlebih dahulu.

         </div>

      @endif

   </div>
</div>

@endsection

@section('script')

<script>

   $(document).ready(function () {

      @if(isset($grades) && $grades->isNotEmpty())

         $('#datatable').DataTable();

      @endif

      $('#datatable').on('click', '.delete', function (e) {

         e.preventDefault();

         const form = $(this).closest('form');

         Swal.fire({
            title: 'Apa kamu yakin?',
            text: "Data nilai ini akan hilang!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
         }).then((result) => {

            if (result.value) {

               form.submit();

            }

         });

      });

   });

</script>

@endsection