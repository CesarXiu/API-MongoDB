<?php

namespace App\Http\Controllers\API;

use App\Models\Movie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $movies = Movie::all();
        return response()->json([
            'movies'=>$movies
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $movie = new Movie();
        $movie->fill($data);
        $movie->save();
        return response()->json([
            'movie'=>$movie
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
        return response()->json([
            'movie'=>$movie
        ]);
        
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
        //dd($movie);
        $movie->fill($request->all())->save();
        return response()->json([
            'movie'=>$movie
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        //
        $movie->delete();
        return response()->json([
            'message'=>'Borrado con exitacion!'
        ]);
    }
}
