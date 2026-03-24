<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $fillable = [
        'nama',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nama_ortu',
        'no_hp_ortu',
        'asal_sekolah',
        'kelas_tujuan',
        'foto',
        'dokumen',
        'status',
    ];
}