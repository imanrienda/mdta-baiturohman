<style>
    body{
        font-family: sans-serif;
        font-size: 12px;
    }

    h3{
        margin-bottom: 20px;
    }

    table{
        border-collapse: collapse;
        width: 100%;
    }

    table,
    th,
    td{
        border: 1px solid black;
    }

    th{
        background: #f2f2f2;
        text-align: center;
        padding: 8px;
    }

    td{
        padding: 6px;
    }

    .text-center{
        text-align: center;
    }
</style>

<center>

    @if($grades->isNotEmpty())

        <h3>
            Nilai Siswa Kelas
            {{ $grades[0]->classStudent->classRoom->nama ?? '-' }}

            Semester
            {{ $grades[0]->semester->tahun_ajaran ?? '-' }}
            |
            {{ $grades[0]->semester->semester ?? '-' }}
        </h3>

    @else

        <h3>Data Nilai Siswa</h3>

    @endif

</center>

@if($grades->isNotEmpty())

<table>

    <thead>
        <tr>
            <th width="5%">No</th>
            <th>Nama</th>
            <th>Mata Pelajaran</th>
            <th>Nilai Tugas 1</th>
            <th>Nilai Tugas 2</th>
            <th>Nilai UTS</th>
            <th>Nilai UAS</th>
            <th>Rata-rata</th>
        </tr>
    </thead>

    <tbody>

        @foreach($grades as $grade)

        <tr>

            <td class="text-center">
                {{ $loop->iteration }}
            </td>

            <td>
                {{ optional($grade->classStudent->student)->nama ?? '-' }}
            </td>

            <td>
                {{ optional($grade->subject)->nama ?? '-' }}
            </td>

            <td class="text-center">
                {{ $grade->nilai_tugas_1 }}
            </td>

            <td class="text-center">
                {{ $grade->nilai_tugas_2 }}
            </td>

            <td class="text-center">
                {{ $grade->nilai_uts }}
            </td>

            <td class="text-center">
                {{ $grade->nilai_uas }}
            </td>

            <td class="text-center">
                {{ round($grade->rata2, 2) }}
            </td>

        </tr>

        @endforeach

    </tbody>

</table>

@else

    <center>
        <h4>Data nilai tidak tersedia</h4>
    </center>

@endif