<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $dates = ['tanggal_lahir'];
    protected $fillable = ['nis', 'nama', 'user_id', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'alamat', 'foto'];

    public function getFoto()
    {
        if (!$this->foto) {
            return asset('img/default.jpg');
        }

        return asset('img/' . $this->foto);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tempat_tanggal_lahir()
    {
        return $this->tempat_lahir . ', ' . $this->tanggal_lahir->format('d M Y');
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function latestClassStudent()
    {
        return $this->hasOne(ClassStudent::class)->latest('id');
    }

    public function classStudent()
    {
        return $this->hasMany(ClassStudent::class);
    }
   public function pendaftaran()
{
    return $this->hasOne(\App\Pendaftaran::class, 'nama', 'nama')
                ->with('semester');
}
}