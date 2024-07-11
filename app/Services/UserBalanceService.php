<?php


namespace App\Services;


use App\DTO\CreateUserBalanceDTO;
use App\Http\Resources\UserBalanceResource;
use App\Models\UserBalance;
use App\Services\Interfaces\UserBalanceServiceInterface;

class UserBalanceService implements UserBalanceServiceInterface
{

    public function store(CreateUserBalanceDTO $createUserBalanceDTO): UserBalanceResource
    {
        $data = $createUserBalanceDTO->getValidatedData();
        $userBalance = UserBalance::create([
            'user_id' => $data['user_id']
        ]);
        return new UserBalanceResource($userBalance);
    }
}
