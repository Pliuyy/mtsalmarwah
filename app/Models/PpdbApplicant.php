<?php

namespace App\Models; // <<< PASTIKAN NAMESPACE INI

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpdbApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_number',
        'full_name',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'previous_school',
        'nisn',
        'father_name',
        'father_job',
        'mother_name',
        'mother_job',
        'parent_phone',
        'parent_email',
        'akta_kelahiran_path',
        'kk_path',
        'ijazah_path',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];
}