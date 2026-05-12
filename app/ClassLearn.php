<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassLearn extends Model
{
    protected $fillable = [
        'class_room_id',
        'subject_id'
    ];

    public function classRoom()
    {
        return $this->belongsTo(\App\ClassRoom::class);
    }

    public function subject()
    {
        return $this->belongsTo(\App\Subject::class);
    }

    public function schedules()
    {
        return $this->hasMany(\App\Schedule::class);
    }

    public function grades()
    {
        return $this->hasMany(\App\Grade::class);
    }
}