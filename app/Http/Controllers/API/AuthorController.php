<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $authors = Author::all();
        return response()->json([
            'authors'=>$authors
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $author = new Author();
        $author->fill($data);
        $author->save();
        return response()->json([
            'author'=>$author
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
        return response()->json([
            'movie'=>$author
        ]);
        
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        //
        //dd($movie);
        $author->fill($request->all())->save();
        return response()->json([
            'author'=>$author
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
        $author->delete();
        return response()->json([
            'message'=>'Borrado con exitacion!'
        ]);
    }
}
