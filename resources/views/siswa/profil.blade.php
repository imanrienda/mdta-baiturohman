@extends('layouts/master')

@section('title', 'Profil')
@section('header', 'Profil')

@section('content')

<div class="row">
   <div class="col-md-3">

      <!-- Profile Image -->
      <div class="card card-primary card-outline">
         <div class="card-body box-profile">
            <div class="text-center">
               <img class="profile-user-img img-fluid img-circle" src="{{ $student->getFoto() }}"
                  alt="User profile picture">
            </div>
            <h3 class="profile-username text-center">{{ $student->nama }}</h3>

            <p class="text-muted text-center">{{ $student->nis }}</p>

            <hr>

            <b><i class="fas fa-calendar-day mr-1"></i> Tempat Tanggal Lahir</b>
            <p class="text-muted">
               {{ $student->tempat_lahir .', '. $student->tanggal_lahir->format('d M Y') }}
            </p>

            <hr>
            <strong><i class="fas fa-venus-mars mr-1"></i> Jenis Kelamin</strong>
            <p class="text-muted">{{ $student->jenis_kelamin }}</p>

            <hr>
            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
            <p class="text-muted">{{ $student->alamat }}</p>

            <hr>
            <strong><i class="fas fa-praying-hands mr-1"></i> Agama</strong>
            <p class="text-muted">{{ $student->agama }}</p>

            <hr>
            <strong><i class="far fa-envelope mr-1"></i> Email</strong>
            {{-- FIX: gunakan null-safe operator agar tidak error jika user tidak ditemukan --}}
            <p class="text-muted">{{ $student->user->email ?? '-' }}</p>

            <hr>

            <a href="/students/{{ $student->id }}/edit" class="btn btn-success btn-sm">Edit</a>

         </div>
         <!-- /.card-body -->
      </div>
      <!-- /.card -->

   </div>
   <!-- /.col -->

   <div class="col-md-9">
      <div class="card card-primary card-outline">
         <div class="card-header p-2">
            <ul class="nav nav-pills">

               @if($grades->isNotEmpty())
                  @foreach ($grades->unique('semester_id') as $grade)
                     @php
                        $sGet = request('s', '');
                        $thn_ajar1    = substr($grade->semester->tahun_ajaran, 2, 2);
                        $thn_ajar2    = substr($grade->semester->tahun_ajaran, 7, 2);
                        $tahun_ajaran = $thn_ajar1 .'/'. $thn_ajar2;
                     @endphp
                     <li class="nav-item">
                        <form action="" method="get" style="display:inline;">
                           <input type="hidden" name="s" value="{{ $grade->semester_id }}" />
                           <button type="submit"
                              class="nav-link btn btn-link @if($sGet == $grade->semester_id) active @endif">
                              {{ $tahun_ajaran .' | '. $grade->semester->semester }}
                           </button>
                        </form>
                     </li>
                  @endforeach
               @endif

            </ul>
         </div>
         <!-- /.card-header -->

         <div class="card-body">
            <div class="tab-content">

               @if($grades->isNotEmpty())
                  @php
                     $sGet         = request('s', '');
                     $classStdId   = $grades->first()->class_student_id;

                     // Ambil data nilai sesuai semester yang dipilih
                     $filteredGrades = $sGet
                        ? \App\Grade::where('semester_id', $sGet)
                              ->where('class_student_id', $classStdId)
                              ->get()
                        : $grades;
                  @endphp

                  <div class="table-responsive">
                     <table class="table table-hover">
                        <thead>
                           <tr>
                              <th>No</th>
                              <th>Mata Pelajaran</th>
                              <th>Kelas</th>
                              <th>Semester</th>
                              <th>Nilai Tugas</th>
                              <th>Nilai UTS</th>
                              <th>Nilai UAS</th>
                              <th>Rata-rata</th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse ($filteredGrades as $item)
                              @php
                                 $jmltugas   = $item->nilai_tugas_1 + $item->nilai_tugas_2;
                                 $rata2tugas = $jmltugas / 2;

                                 $tugas = $rata2tugas * 25 / 100;
                                 $uts   = $item->nilai_uts * 35 / 100;
                                 $uas   = $item->nilai_uas * 40 / 100;
                                 $rata2 = $tugas + $uts + $uas;
                              @endphp
                              <tr>
                                 <td>{{ $loop->iteration }}</td>
                                 <td>{{ $item->classLearn->subject->nama }}</td>
                                 <td>{{ $item->classLearn->classRoom->nama }}</td>
                                 <td>{{ $item->semester->tahun_ajaran .' | '. $item->semester->semester }}</td>
                                 <td>{{ $rata2tugas }}</td>
                                 <td>{{ $item->nilai_uts }}</td>
                                 <td>{{ $item->nilai_uas }}</td>
                                 <td>{{ number_format($rata2, 2) }}</td>
                              </tr>
                           @empty
                              <tr>
                                 <td colspan="8" class="text-center text-muted">
                                    Pilih semester untuk melihat nilai
                                 </td>
                              </tr>
                           @endforelse
                        </tbody>
                     </table>
                  </div>

               @else
                  <p class="text-muted text-center mt-3">Belum ada nilai</p>
               @endif

            </div>
            <!-- /.tab-content -->
         </div>
         <!-- /.card-body -->
      </div>
   </div>
   <!-- /.col -->
</div>

@endsection