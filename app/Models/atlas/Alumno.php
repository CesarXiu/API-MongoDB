<?php

namespace App\Models\atlas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
//use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'Alumnos';
    /*protected $fillable = [
        'nombre',
        'edad',
        'curso',
        'notas',
        'direccion',
    ];*/
}
