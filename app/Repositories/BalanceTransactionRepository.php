<?php


namespace App\Repositories;


use App\Http\Resources\UserBalanceResource;
use App\Models\BalanceTransaction;
use App\Models\UserBalance;
use App\Repositories\Interfaces\BalanceTransactionRepositoryInterface;
use App\Repositories\Interfaces\UserBalanceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BalanceTransactionRepository implements BalanceTransactionRepositoryInterface
{

    public function getByUserId(int $userId): Collection
    {
        return BalanceTransaction::where('user_id', $userId)->get();
    }
}
