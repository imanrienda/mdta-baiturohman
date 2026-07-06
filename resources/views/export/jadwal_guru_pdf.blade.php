<style>
table {
    border-collapse: collapse;
    width: 100%;
}

table, td, th {
    border: 1px solid black;
    padding: 10px;
}
</style>

<center>
    <h3>
        Jadwal Mengajar Guru
        {{ $schedule[0]->teacher->nama ?? '' }}
        <br>
        Semester
        {{ $schedule[0]->semester->tahun_ajaran ?? '' }}
        |
        {{ $schedule[0]->semester->semester ?? '' }}
    </h3>
</center>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Hari</th>
            <th>Jam</th>
            <th>Kelas</th>
            <th>Mata Pelajaran</th>
        </tr>
    </thead>

    <tbody>

    @foreach($schedule as $s)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $s->hari }}</td>
            <td>{{ $s->jam_mulai }} - {{ $s->jam_selesai }}</td>
            <td>{{ $s->classRoom->nama ?? '-' }}</td>
            <td>{{ $s->subject->nama ?? '-' }}</td>
        </tr>

    @endforeach

    </tbody>
</table>