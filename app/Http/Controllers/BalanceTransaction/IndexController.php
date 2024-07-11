<?php

namespace App\Http\Controllers\BalanceTransaction;

use App\Http\Controllers\Controller;
use App\Http\Resources\BalanceTransactionResource;
use App\Repositories\Interfaces\BalanceTransactionRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class IndexController extends Controller
{
    public function __invoke(Request $request, BalanceTransactionRepositoryInterface $balanceTransactionRepository): ResourceCollection
    {
        return BalanceTransactionResource::collection(
            $balanceTransactionRepository->getByUserId(userId: $request->user()->id)
        );
    }
}
