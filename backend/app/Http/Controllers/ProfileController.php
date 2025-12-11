<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthUserRequest;
use App\Http\Requests\StoreAvatarRequest;
use App\Models\Avatar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function avatar(StoreAvatarRequest $request)
    {
        $data = $request->validated();
        $file = $request->file('path_to_avatar');
        $filePath = $file->storeAs('avatars', $file->getClientOriginalName(), 'public');

        $user = Auth::user();
        $userId = $user->id;
        $avatar = Avatar::create([
            'user_id' => $user->id,
            'path_to_avatar' => $filePath
        ]);
        return response()->json([
            'filePath' => $filePath,
            'user' => $user
        ]);
    }
}
