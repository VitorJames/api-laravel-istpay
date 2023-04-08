<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vaga extends Model
{
    use HasFactory;

    protected $table = 'vagas';
    protected $fillable = [
        'title',
        'company',
        'description',
        'requirements',
        'salary',
        'type',
        'modality',
        'status',
    ];

    public function candidaturas() {
        return $this->hasMany(Candidatura::class, 'vaga_id');
    }
}
