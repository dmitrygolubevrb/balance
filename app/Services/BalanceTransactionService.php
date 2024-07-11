<?php


namespace App\Services;


use App\DTO\CreateBalanceTransactionDTO;
use App\Models\BalanceTransaction;
use App\Models\User;
use App\Models\UserBalance;
use App\Repositories\Interfaces\UserBalanceRepositoryInterface;
use App\Services\Interfaces\BalanceTransactionServiceInterface;
use Illuminate\Support\Facades\DB;

class BalanceTransactionService implements BalanceTransactionServiceInterface
{

    public function executeTransaction(CreateBalanceTransactionDTO $balanceTransactionDTO, UserBalanceRepositoryInterface $userBalanceRepository)
    {
        DB::beginTransaction();
        try {
            $data = $balanceTransactionDTO->getValidatedData();
            $user = User::find($data['user_id']);
            $userBalance = $userBalanceRepository->getByUserIdWithLock(userId: $user->id);
            $modelOperationName = $data['type'] === BalanceTransaction::TYPE_CREDIT ? 'increment' : 'decrement';
            $balanceTransaction = BalanceTransaction::create([
                'user_id' => $data['user_id'],
                'type' => $data['type'],
                'amount' => $data['amount'],
                'description' => $data['description'],
                'balance_after' => $data['type'] === BalanceTransaction::TYPE_CREDIT ?
                    bcadd($userBalance->balance, $data['amount']) :
                    bcsub($userBalance->balance, $data['amount'])
            ]);
            $userBalance->$modelOperationName('balance', $data['amount']);
            DB::commit();
            return $balanceTransaction;
        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }
}
