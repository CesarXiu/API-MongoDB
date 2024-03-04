<?php

namespace App\Models\atlas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use App\Models\atlas\Carrera;

class Departamento extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'Departamentos';
    protected $fillable = [
        'name',
        'carreras'
    ];
    public function carreras(){
        return $this->hasMany(Carrera::class);
    }
}
