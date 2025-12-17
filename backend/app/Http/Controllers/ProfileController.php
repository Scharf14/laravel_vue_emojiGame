<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreAvatarRequest;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function setAvatar(StoreAvatarRequest $request)
    {
        //сохраняем в хранилище
        $data = $request->validated();
        $file = $request->file('path_to_avatar');
        $filePath = $file->storeAs('avatars', $file->getClientOriginalName(), 'public');

        //создаем запись в бд
        $user = Auth::user();
        $userId = $user->id;
        $avatar = Avatar::create([
            'user_id' => $user->id,
            'path_to_avatar' => $filePath
        ]);

        return response()->json([
            'filePath' => $filePath,
        ]);
    }

    public function getAvatar(Request $request)
    {
        $userId = Auth::user()->id;
        $Avatar = Avatar::where('user_id', $userId)->latest()->first();
        $filepath = Storage::disk('public')->path($Avatar->path_to_avatar);
        return response()->file($filepath);
    }
}
