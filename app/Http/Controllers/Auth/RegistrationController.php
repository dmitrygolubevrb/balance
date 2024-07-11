<?php

namespace App\Http\Controllers\Auth;

use App\DTO\CreateUserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Interfaces\UserBalanceServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{

    public function __invoke(RegistrationRequest $registrationRequest, UserService $userService)
    {
        $registrationData = $registrationRequest->validated();
        $userDTO = new CreateUserDTO(
            full_name: $registrationData['full_name'],
            login: $registrationData['login'],
            password: $registrationData['password'],
            password_confirmation: $registrationData['password']
        );
        $user = $userService->store(
            userDTO: $userDTO,
            userBalanceService: app()->make(UserBalanceServiceInterface::class)
        );
        return new UserResource($user);
    }

}
