@extends('layouts/master')

@section('title', 'Nilai')
@section('header', 'Data Nilai')

@section('content')

<div class="row">
   <div class="col-lg">

      {{-- FORM FILTER --}}
      <form action="/student/grades" method="get">
         <div class="row">

            {{-- PILIH KELAS --}}
            <div class="col-auto">
               <div class="form-group">
                  <select name="kelas" id="kelas" class="form-control" required>
                     <option value="">Pilih kelas</option>

                     @foreach ($classes as $class)

                        @if($class->classRoom)

                           <option
                              value="{{ $class->class_room_id }}"
                              {{ request('kelas') == $class->class_room_id ? 'selected' : '' }}
                           >
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

                        <option
                           value="{{ $semester->id }}"
                           {{ request('semester') == $semester->id ? 'selected' : '' }}
                        >
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

      {{-- ALERT SUCCESS --}}
      @if(session('status'))

         <div class="alert alert-success mt-3">
            {{ session('status') }}
         </div>

      @endif

      {{-- TAMPILKAN DATA --}}
      @if(request('kelas') && request('semester'))

         <div class="card mt-3">

            <div class="card-header">
               <div class="card-title">

                  Data Nilai

                  @if($student && $student->classRoom)
                     Kelas {{ $student->classRoom->nama }}
                  @endif

               </div>
            </div>

            <div class="card-body">

               <a
                  href="/student/export-nilai-siswa/{{ request('kelas') }}/{{ request('semester') }}"
                  class="btn btn-primary btn-sm mb-3"
               >
                  Export PDF
               </a>

               @if($nilai->isNotEmpty())

                  <table class="table table-bordered table-hover" id="datatable">

                     <thead class="thead-light">
                        <tr>
                           <th>No</th>
                           <th>Mata Pelajaran</th>
                           <th>Nilai Tugas 1</th>
                           <th>Nilai Tugas 2</th>
                           <th>Nilai UTS</th>
                           <th>Nilai UAS</th>
                           <th>Rata-rata</th>
                        </tr>
                     </thead>

                     <tbody>

                        @foreach ($nilai->unique('subject_id') as $grade)

                           <tr>

                              <td>{{ $loop->iteration }}</td>

                              <td>
                                 {{ isset($grade->subject) && $grade->subject
                                    ? strtoupper($grade->subject->nama)
                                    : '-' }}
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
                                 {{
                                    isset($grade->rata2) && $grade->rata2 > 0
                                    ? number_format($grade->rata2, 2)
                                    : '-'
                                 }}
                              </td>

                           </tr>

                        @endforeach

                        {{-- TOTAL RATA-RATA --}}
                        <tr class="font-weight-bold">

                           <td colspan="6" class="text-center">
                              Rata-rata Keseluruhan
                           </td>

                           <td>
                              {{ $total > 0 ? number_format($total, 2) : '-' }}
                           </td>

                        </tr>

                     </tbody>

                  </table>

               @else

                  <div class="alert alert-warning">
                     Data nilai tidak ditemukan.
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

      @if(isset($nilai) && $nilai->isNotEmpty())

         $('#datatable').DataTable();

      @endif

   });

</script>

@endsection