<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilmRequest;
use App\Models\UserStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Film;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Random;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getGameData()
    {
        $films = Film::inRandomOrder()->limit(4)->get();
        $correctFilm = $films->random();
        $correctFilmId = $correctFilm->id;

        foreach ($films as $film) {
            $film->is_correct = ($film->id === $correctFilmId);
        }

        return response()->json([
            'films' => $films,
        ]);
    }

    public function getFrame(Request $request)
    {
        $goodId = $request->get('id');

        $goodFilm = Film::find($goodId);

        $goodFilmFrame = Storage::disk('public')->path($goodFilm->path_to_film);
        return response()->file($goodFilmFrame);
    }

    public function getFilm()
    {
        $lastUser = Film::latest()->first();

        $localPath = Storage::disk('public')->path($lastUser->path_to_film);

        $lastUser = storage_path($lastUser->path_to_film);

        return response()->json([
            'lastUser' => $lastUser,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
