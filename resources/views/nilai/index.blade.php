@extends('layouts/master')

@section('title', 'Nilai')
@section('header', 'Data Nilai')

@section('content')

<div class="row">
   <div class="col-lg">

      {{-- FILTER --}}
      <form action="/grades" method="get">
         <div class="row">

            <div class="col-auto">
               <div class="form-group">
                  <select name="kelas" id="kelas" class="form-control" required>
                     <option value="">Pilih kelas</option>

                     @foreach ($classes as $class)

                     <option
                        value="{{ $class->id }}"
                        {{ request('kelas') == $class->id ? 'selected' : '' }}>

                        {{ $class->nama }}

                     </option>

                     @endforeach

                  </select>
               </div>
            </div>

            <div class="col-auto">
               <div class="form-group">
                  <select name="semester" id="semester" class="form-control" required>

                     <option value="">Pilih semester</option>

                     @foreach ($semesters as $semester)

                     <option
                        value="{{ $semester->id }}"
                        {{ request('semester') == $semester->id ? 'selected' : '' }}>

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

      {{-- HASIL --}}
      @if(request()->filled('kelas') && request()->filled('semester'))

      <div class="card mt-3">

         <div class="card-header">

            <div class="card-title">

               @if($grades->isNotEmpty())

                  Data Nilai
                  Kelas
                  {{ optional(optional($grades->first()->classStudent)->classRoom)->nama ?? '-' }}

                  Semester
                  {{ optional($grades->first()->semester)->tahun_ajaran ?? '-' }}
                  |
                  {{ optional($grades->first()->semester)->semester ?? '-' }}

               @else

                  Data Nilai

               @endif

            </div>

         </div>

         <div class="card-body">

            {{-- BUTTON --}}
            <a
               href="/grades/{{ request('kelas') }}/{{ request('semester') }}/create"
               class="btn btn-primary btn-sm mb-3">

               Tambah Nilai

            </a>

            <a
               href="/export-nilai/{{ request('kelas') }}/{{ request('semester') }}"
               class="btn btn-info btn-sm mb-3">

               Export PDF

            </a>

            {{-- TABEL --}}
            @if($grades->isNotEmpty())

            <table class="table table-bordered table-hover" id="datatable">

               <thead class="thead-light">
                  <tr>
                     <th>No</th>
                     <th>Nama</th>
                     <th>Mata Pelajaran</th>
                     <th>Nilai Tugas 1</th>
                     <th>Nilai Tugas 2</th>
                     <th>Nilai UTS</th>
                     <th>Nilai UAS</th>
                     <th>Rata-rata</th>
                     <th>Aksi</th>
                  </tr>
               </thead>

               <tbody>

                  @foreach ($grades as $grade)

                  <tr>

                     <td>
                        {{ $loop->iteration }}
                     </td>

                     <td>
                        {{ optional(optional($grade->classStudent)->student)->nama ?? '-' }}
                     </td>

                     <td>
                        {{ optional($grade->subject)->nama ?? '-' }}
                     </td>

                     <td>
                        {{ $grade->nilai_tugas_1 ?? '-' }}
                     </td>

                     <td>
                        {{ $grade->nilai_tugas_2 ?? '-' }}
                     </td>

                     <td>
                        {{ $grade->nilai_uts ?? '-' }}
                     </td>

                     <td>
                        {{ $grade->nilai_uas ?? '-' }}
                     </td>

                     <td>
                        {{ isset($grade->rata2) ? number_format($grade->rata2, 2) : '-' }}
                     </td>

                     <td>

                        <a
                           href="/grades/{{ $grade->id }}/edit"
                           class="btn btn-warning btn-sm">

                           Edit

                        </a>

                        <form
                           action="/grades/{{ $grade->id }}"
                           method="post"
                           class="d-inline form-delete">

                           @csrf
                           @method('DELETE')

                           <button
                              type="submit"
                              class="btn btn-danger btn-sm">

                              Hapus

                           </button>

                        </form>

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

         Untuk menampilkan nilai pilih kelas dan semester terlebih dahulu.

      </div>

      @endif

   </div>
</div>

@endsection

@section('script')

<script>

   $(document).ready(function () {

      @if(request()->filled('kelas') &&
         request()->filled('semester') &&
         $grades->isNotEmpty())

         $('#datatable').DataTable();

      @endif


      $('.form-delete').submit(function(e) {

         e.preventDefault();

         let form = this;

         Swal.fire({
            title: 'Apa kamu yakin?',
            text: 'Data nilai akan dihapus!',
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