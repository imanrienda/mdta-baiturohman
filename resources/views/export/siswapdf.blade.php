<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }
        h3 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, td, th {
            border: 1px solid black;
        }
        th, td {
            padding: 5px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h3>Data Siswa</h3>
    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Agama</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $student->nis }}</td>
                <td>{{ $student->nama }}</td>
                <td>{{ $student->tempat_tanggal_lahir() }}</td>
                <td>{{ $student->jenis_kelamin }}</td>
                <td>{{ $student->alamat }}</td>
                <td>{{ $student->agama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>