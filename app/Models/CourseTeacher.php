<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTeacher extends Model
{
    protected $table = 'course_teacher';
    protected $fillable = ['course_id', 'teacher_id'];
}
