<?php

namespace App\Models\atlas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use App\Models\atlas\Departamento;
use Illuminate\Support\Facades\DB;

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
        return DB::collection('Departamentos')->where('carreras._id', $this->_id)->first();
    }
}
