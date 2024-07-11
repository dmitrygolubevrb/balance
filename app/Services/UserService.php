<?php


namespace App\Services;


use App\DTO\CreateUserBalanceDTO;
use App\DTO\CreateUserDTO;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Interfaces\UserBalanceServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{

    public function store(CreateUserDTO $userDTO, UserBalanceServiceInterface $userBalanceService): UserResource|string
    {
        DB::beginTransaction();
        try {
            $data = $userDTO->getValidatedData();
            $user = User::create([
                'full_name' => $data['full_name'],
                'login' => $data['login'],
                'password' => Hash::make($data['password'])
            ]);
            $userBalanceService->store((new CreateUserBalanceDTO(user_id: $user->id)));
            DB::commit();
            return new UserResource($user);

        } catch (\Exception $exception) {
            DB::rollBack();
            return $exception->getMessage();
        }
    }

}
