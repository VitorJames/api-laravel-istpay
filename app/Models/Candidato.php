<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidato extends Model
{
    use HasFactory;

    protected $table = 'candidatos';
    protected $fillable = [
        'first_name',
        'full_name',
        'phone',
        'address',
        'job_title',
        'experiences',
        'skills',
        'experience_level',
    ];

    public function candidaturas() {
        return $this->hasMany(Candidatura::class, 'candidato_id');
    }
}
