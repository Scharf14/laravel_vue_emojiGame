<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditStatsRequest;
use App\Http\Requests\StoreFilmRequest;
use App\Models\UserStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Film;
use Illuminate\Support\Facades\Storage;
use Nette\Utils\Random;
use App\Models\User;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getGameData()
    {
        $films = Film::inRandomOrder()->limit(2)->get();
        $correctFilm = $films->random();
        $correctFilmId = $correctFilm->id;

        foreach ($films as $film) {
            $film->is_correct = ($film->id === $correctFilmId);
        }

        return response()->json([
            'films' => $films,
        ]);
    }

    public function getFrame(Film $film)
    {
        $goodFilmFrame = Storage::disk('public')->path($film->path_to_film);
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
    public function saveStatistics(Request $request)
    {
        $userId = Auth::user()->id;

        $experience = $request->experience;
        $winningStreak = $request->winningStreak;
        $level = $request->level;

        if($experience !== null) {
            UserStat::where('user_id', $userId)->update(['experience' => $experience]);
        }
        if($winningStreak !== null) {
            UserStat::where('user_id', $userId)->update(['winning_streak' => $winningStreak]);
        }
        if($level !== null) {
            UserStat::where('user_id', $userId)->update(['level' => $level]);
        }

        return response()->json([
            'experience' => $experience,
            'winningStreak' => $winningStreak,
            'level' => $level,
            'message' => 'ответ пришел'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function getStatistics(Request $request)
    {
        $userId = Auth::user()->id;

        $userStats = UserStat::where('user_id', $userId)->first();

        $stats = [
            'level' => $userStats->level,
            'winningStreak' => $userStats->winning_streak,
            'experience' => $userStats->experience,
        ];
        return response()->json($stats);
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
