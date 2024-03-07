<?php

namespace App\Models\atlas;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use App\Models\atlas\Carrera;
use Illuminate\Support\Facades\DB;
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
    public function pullCarrera(Carrera $carrera){
        DB::collection('Departamentos')->where('_id', $this->_id)->pull('carreras', ['name'=>$carrera->name]);
        //$this->save();
    }
}
