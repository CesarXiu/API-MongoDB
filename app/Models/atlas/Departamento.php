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
    public $timestamps = false;
    protected $fillable = [
        'name',
        'carreras'
    ];
    public function carreras(){
        return $this->embedsMany(Carrera::class);
    }
    public function removerCarrera($carrera){
        //DB::collection('users')->where('name', 'John')->pull('items', 'boots');
        $this->pull('miArray', $carrera);
        $this->save();
    }
}
