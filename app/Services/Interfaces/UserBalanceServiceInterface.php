<?php


namespace App\Services\Interfaces;


use App\DTO\CreateUserBalanceDTO;
use App\Http\Resources\UserBalanceResource;

interface UserBalanceServiceInterface
{

    public function store(CreateUserBalanceDTO $createUserBalanceDTO): UserBalanceResource;

}
