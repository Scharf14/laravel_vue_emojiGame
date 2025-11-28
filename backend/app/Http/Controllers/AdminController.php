<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilmRequest;
use Illuminate\Http\Request;
use App\Models\Film;

class AdminController extends Controller
{
    public function film(StoreFilmRequest $request)
    {
       $data = $request->validated();
       $file = $request->file('path_to_film');
       $filePath = $file->storeAs('films', $file->getClientOriginalName());

       $film = Film::create([
           'name' => $request->name,
           'difficult_id' => $request->difficult_id,
           'path_to_film' => $filePath
       ]);

       return response()->json([
          'film'=> $film
       ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
