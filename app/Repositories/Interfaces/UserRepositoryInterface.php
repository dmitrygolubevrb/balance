<?php


namespace App\Repositories\Interfaces;


use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

interface UserRepositoryInterface
{
    public function getAll(): ResourceCollection;

    public function getByLogin(string $login): UserResource;

}
