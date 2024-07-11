<?php


namespace App\Repositories\Interfaces;


use Illuminate\Database\Eloquent\Collection;

interface BalanceTransactionRepositoryInterface
{
    public function getByUserId(int $userId): Collection;
}
