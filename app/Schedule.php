<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'class_learn_id',
        'class_room_id',
        'subject_id',
        'semester_id',
        'teacher_id'
    ];

    public function classLearn()
    {
        return $this->belongsTo(\App\ClassLearn::class, 'class_learn_id');
    }

    public function classRoom()
    {
        return $this->belongsTo(\App\ClassRoom::class);
    }

    public function subject()
    {
        return $this->belongsTo(\App\Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Teacher::class);
    }

    public function semester()
    {
        return $this->belongsTo(\App\Semester::class);
    }
}