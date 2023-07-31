<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencias extends Model
{
    use HasFactory;

    public $timestamps = true;

    public function usuario(){
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}
