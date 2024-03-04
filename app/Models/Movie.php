<?php

namespace App\Models;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
//use Illuminate\Database\Eloquent\Model;
class Movie extends Model
{
    use HasFactory;
    protected $connection = 'mongodb';
    protected $fillable = ['title', 'year', 'runtime', 'imdb', 'plot','directors'];

    public function directors(){
        return $this->hasMany(Author::class);
    }
}
