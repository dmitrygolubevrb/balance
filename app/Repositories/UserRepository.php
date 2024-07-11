<?php


namespace App\Repositories;


use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserRepository implements UserRepositoryInterface
{
    public function getByLogin(string $login): UserResource
    {
        $user = User::where('login', 'ilike', $login)->first();
        return new UserResource($user);
    }

    public function getAll(): ResourceCollection
    {
        return UserResource::collection(User::all());
    }
}
