<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    // Nama tabel secara eksplisit jika nama model tidak sesuai konvensi (StudentAchievement -> student_achievements)
    // protected $table = 'students_achievements'; // Hanya jika nama tabel tidak teratur

    protected $fillable = [
        'student_name',
        'achievement',
        'published_at',
        'photo',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}