<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    // Importante: incluir 'course_id' para poder guardarlo
    protected $fillable = ['name', 'email', 'course_id'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}