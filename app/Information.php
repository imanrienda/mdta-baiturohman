<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table = 'informations';

    protected $fillable = [
        'judul',
        'konten',
        'publish',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}