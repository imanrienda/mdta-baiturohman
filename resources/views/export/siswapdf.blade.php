<style>
    body {
        font-family: sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    table, td, th {
        border: 1px solid black;
        padding: 6px 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    h3 {
        margin-bottom: 4px;
    }

    p.sub {
        margin-top: 0;
        font-size: 13px;
        color: #444;
    }
</style>

<center>
    <h3>Data Siswa</h3>
    <p class="sub">Semester {{ $semester->tahun_ajaran }} | {{ $semester->semester }}</p>
</center>

<table>
    <thead>
        <tr>
            <th width="5%">No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>Tempat Tanggal Lahir</th>
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