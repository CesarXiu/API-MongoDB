<?php

namespace App\Models\atlas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use App\Models\atlas\Departamento;

class Carrera extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $collection = 'Carreras';
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}
