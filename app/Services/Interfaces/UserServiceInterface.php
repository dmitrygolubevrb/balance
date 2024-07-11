<?php


namespace App\Services\Interfaces;


use App\DTO\CreateUserDTO;
use App\Http\Resources\UserResource;

interface UserServiceInterface
{

    public function store(CreateUserDTO $userDTO, UserBalanceServiceInterface $userBalanceService): UserResource|string;

}
