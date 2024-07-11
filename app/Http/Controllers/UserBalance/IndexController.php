<?php

namespace App\Http\Controllers\UserBalance;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserBalanceResource;
use App\Models\User;
use App\Repositories\Interfaces\UserBalanceRepositoryInterface;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request, UserBalanceRepositoryInterface $userBalanceRepository): UserBalanceResource
    {
        return new UserBalanceResource($userBalanceRepository->getByUserId($request->user()->id));
    }
}
