<?php


namespace App\Services\Interfaces;


use App\DTO\CreateBalanceTransactionDTO;
use App\Repositories\Interfaces\UserBalanceRepositoryInterface;

interface BalanceTransactionServiceInterface
{

    public function executeTransaction(CreateBalanceTransactionDTO $balanceTransactionDTO, UserBalanceRepositoryInterface $userBalanceRepository);

}
