<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $dates = ['tanggal_lahir'];

    protected $fillable = [
        'nrg',
        'nama',
        'user_id',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'telp',
        'alamat',
        'foto',
    ];

    /**
     * ✅ FIX: Tambah slash antara 'img/guru/' dan nama file,
     *         tambah pengecekan file_exists seperti Student model.
     */
    public function getFoto()
    {
        if (!empty($this->foto) && file_exists(public_path('img/guru/' . $this->foto))) {
            return asset('img/guru/' . $this->foto);
        }
        return asset('img/default.jpg');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classRoom()
    {
        return $this->hasOne(ClassRoom::class);
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function grade()
    {
        return $this->hasMany(Grade::class);
    }

    public function homeroomTeacher()
    {
        return $this->hasMany(HomeroomTeacher::class);
    }
}