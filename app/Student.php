<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
        'user_id',
        'nis',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'alamat',
        'foto',
    ];

    protected $dates = ['tanggal_lahir'];

    /**
     * Relasi ke tabel users
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    /**
     * Relasi ke class students
     */
    public function classStudents()
    {
        return $this->hasMany(\App\ClassStudent::class, 'student_id');
    }

    /**
     * Helper: gabungkan tempat lahir dan tanggal lahir
     * Contoh output: "Jakarta, 01 Januari 2000"
     */
    public function tempat_tanggal_lahir()
    {
        if ($this->tanggal_lahir) {
            return $this->tempat_lahir . ', ' . Carbon::parse($this->tanggal_lahir)->translatedFormat('d F Y');
        }
        return $this->tempat_lahir;
    }

    /**
     * Helper: ambil foto, jika tidak ada tampilkan default
     */
    public function getFoto()
    {
        if (!empty($this->foto) && file_exists(public_path('img/' . $this->foto))) {
            return asset('img/' . $this->foto);
        }
        return asset('img/default.png');
    }
}