<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'class_student_id',
        'subject_id',
        'class_room_id',
        'semester_id',
        'teacher_id',
        'student_id',
        'nilai_tugas_1',
        'nilai_tugas_2',
        'nilai_uts',
        'nilai_uas',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function classStudent()
    {
        return $this->belongsTo(\App\ClassStudent::class);
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

    public function classRoom()
    {
        return $this->belongsTo(\App\ClassRoom::class);
    }

    public function student()
    {
        return $this->belongsTo(\App\Student::class);
    }

    public function classLearn()
    {
        return $this->belongsTo(\App\ClassLearn::class);
    }
}