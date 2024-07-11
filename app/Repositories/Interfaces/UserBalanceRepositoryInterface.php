<?php


namespace App\Repositories\Interfaces;


use App\Models\UserBalance;

interface UserBalanceRepositoryInterface
{
    public function getByUserIdWithLock(int $userId): UserBalance;

    public function getByUserId(int $userId): UserBalance;
}
