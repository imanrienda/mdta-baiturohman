<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Nilai Siswa</title>

    <style>
        body{
            font-family: sans-serif;
            font-size: 12px;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td{
            border: 1px solid black;
        }

        th, td{
            padding: 8px;
            text-align: center;
        }

        .text-left{
            text-align: left;
        }

        h2, h4{
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>

    <center>
        <h2>LAPORAN NILAI SISWA</h2>
        <h4>
            Semester :
            {{ $semester->tahun_ajaran ?? '-' }}
            |
            {{ $semester->semester ?? '-' }}
        </h4>
    </center>

    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th class="text-left">Mata Pelajaran</th>
                <th>Tugas 1</th>
                <th>Tugas 2</th>
                <th>UTS</th>
                <th>UAS</th>
                <th>Rata-rata</th>
            </tr>
        </thead>

        <tbody>

            @php
                $total = 0;
                $jumlah = 0;
            @endphp

            @foreach($grades as $grade)

                @php

                    $rata2Tugas =
                        (($grade->nilai_tugas_1 ?? 0) +
                        ($grade->nilai_tugas_2 ?? 0)) / 2;

                    $rata2 =
                        ($rata2Tugas * 0.25) +
                        (($grade->nilai_uts ?? 0) * 0.35) +
                        (($grade->nilai_uas ?? 0) * 0.40);

                    $total += $rata2;
                    $jumlah++;

                @endphp

                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td class="text-left">
                        {{ $grade->subject->nama ?? '-' }}
                    </td>

                    <td>{{ $grade->nilai_tugas_1 ?? '-' }}</td>
                    <td>{{ $grade->nilai_tugas_2 ?? '-' }}</td>
                    <td>{{ $grade->nilai_uts ?? '-' }}</td>
                    <td>{{ $grade->nilai_uas ?? '-' }}</td>

                    <td>
                        {{ number_format($rata2, 2) }}
                    </td>
                </tr>

            @endforeach

            <tr>
                <th colspan="6">
                    Rata-rata Keseluruhan
                </th>

                <th>
                    {{
                        $jumlah > 0
                        ? number_format($total / $jumlah, 2)
                        : '0'
                    }}
                </th>
            </tr>

        </tbody>
    </table>

</body>
</html>