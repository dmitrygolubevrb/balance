<?php

namespace App\Jobs;

use App\DTO\CreateBalanceTransactionDTO;
use App\Models\User;
use App\Models\UserBalance;
use App\Repositories\Interfaces\UserBalanceRepositoryInterface;
use App\Services\BalanceTransactionService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Throwable;

class BalanceTransactionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private CreateBalanceTransactionDTO $balanceTransactionDTO;
    private BalanceTransactionService $balanceTransactionService;

    /**
     * Create a new job instance.
     */
    public function __construct(BalanceTransactionService $balanceTransactionService, CreateBalanceTransactionDTO $balanceTransactionDTO)
    {
        $this->balanceTransactionService = $balanceTransactionService;
        $this->balanceTransactionDTO = $balanceTransactionDTO;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Redis::funnel("balance_transaction_user_{$this->balanceTransactionDTO->user_id}")
            ->limit(1)
            ->then(function (){
                $this->balanceTransactionService->executeTransaction(
                    balanceTransactionDTO: $this->balanceTransactionDTO,
                    userBalanceRepository: app()->make(UserBalanceRepositoryInterface::class)
                );
            },function (){
                $this->release(10);
            });
    }


}
