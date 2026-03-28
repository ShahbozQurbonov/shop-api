<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserPhotoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    public function index(User $user)
    {
        return $this->response($user->photos);
    }

    public function store(Request $request, User $user)
    {
        $this->authorizeUserPhotoAccess($request->user(), $user);

        $data = $request->validate([
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $file = $data['photo'];
        $path = $file->store("users/{$user->id}", 'public');

        $photo = $user->photos()->create([
            'full_name' => $file->getClientOriginalName(),
            'path' => $path,
        ]);

        return $this->success('Акс бо муваффақият илова шуд', $photo);
    }

    public function show(User $user, Photo $photo)
    {
        if ($photo->photoable_type !== User::class || $photo->photoable_id !== $user->id) {
            return $this->error('Маълумоти дархостшуда ёфт нашуд', null, 404);
        }

        return $this->response($photo);
    }

    public function update(Request $request, User $user, Photo $photo)
    {
        $this->authorizeUserPhotoAccess($request->user(), $user);

        if ($photo->photoable_type !== User::class || $photo->photoable_id !== $user->id) {
            return $this->error('Маълумоти дархостшуда ёфт нашуд', null, 404);
        }

        $data = $request->validate([
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        Storage::disk('public')->delete($photo->path);

        $file = $data['photo'];
        $path = $file->store("users/{$user->id}", 'public');

        $photo->update([
            'full_name' => $file->getClientOriginalName(),
            'path' => $path,
        ]);

        return $this->success('Акс навсозӣ шуд', $photo);
    }

    public function destroy(Request $request, User $user, Photo $photo)
    {
        $this->authorizeUserPhotoAccess($request->user(), $user);

        if ($photo->photoable_type !== User::class || $photo->photoable_id !== $user->id) {
            return $this->error('Маълумоти дархостшуда ёфт нашуд', null, 404);
        }

        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return $this->success('Акс нест карда шуд');
    }

    private function authorizeUserPhotoAccess(User $authUser, User $targetUser): void
    {
        if ($authUser->id === $targetUser->id || $authUser->can('user:update')) {
            return;
        }

        throw new AuthorizationException('Unauthorized');
    }
}
