<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'published_at',
        'subject',
        'photo',
        'bio',
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
}