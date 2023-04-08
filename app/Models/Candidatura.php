<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidatura extends Model
{
    protected $table = 'candidaturas';
    protected $fillable = [
        'candidato_id',
        'vaga_id',
    ];

    public function candidato() {
        return $this->hasOne(Candidato::class, 'id', 'candidato_id');
    }

    public function vaga() {
        return $this->hasOne(Vaga::class, 'id', 'vaga_id');
    }
}
