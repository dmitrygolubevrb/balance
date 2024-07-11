<?php

namespace App\Console\Commands;

use App\DTO\CreateUserDTO;
use App\Models\User;
use App\Services\Interfaces\UserBalanceServiceInterface;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use function Laravel\Prompts\error;
use function Laravel\Prompts\password;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\text;

class StoreUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление нового пользователя';

    /**
     * Execute the console command.
     */
    public function handle(UserService $userService)
    {
        $fullName = text(
            label: 'Введите ФИО пользователя.',
            required: 'ФИО обязательно к заполнению.',
            validate: fn(string $value) => match (true) {
            strlen($value) < 6 => 'ФИО не должно быть короче 6 символов.',
            strlen($value) > 60 => 'ФИО не должно быть длинее 60 символов.',
            default => null
        },
            hint: 'ФИО создаваемого пользователя.',
        );
        $login = text(
            label: 'Введите логин пользователя.',
            required: 'Логин обязателен к заполнению.',
            validate: fn(string $value) => match (true) {
                strlen($value) < 4 => 'Логин не должен быть короче 4 символов.',
                strlen($value) > 60 => 'Логин не должен быть длинее 60 символов.',
                User::loginExists($value) => 'Пользователь с таким логином уже существует.',
                default => null
            },
            hint: 'Логин создаваемого пользователя.',
        );
        $password = password(
            label: 'Введите пароль пользователя.',
            required: 'Пароль обязателен к заполнению.',
            validate: fn(string $value) => match (true) {
                strlen($value) < 6 => 'Пароль должен быть не короче 6 символов.',
                strlen($value) > 60 => 'Логин должен быть не длинее 60 символов.',
                default => null
            },
            hint: 'Пароль создаваемого пользователя.',
        );

        $passwordConfirmationCounter = 0;
        $passwordConfirmation = password(
            label: 'Подтвердите пароль пользователя.',
            required: 'Потверждение пароля обязательно.',
            validate: function (string $value) use ($password, &$passwordConfirmationCounter) {
                if ($passwordConfirmationCounter < 2) {
                    $passwordConfirmationCounter++;
                    return match (true) {
                        $value !== $password => 'Введенные пароли не совпадают.',
                        default => null
                    };
                } else {
                    $this->error('Введенные пароли не совпадают, повторите попытку.');
                    return false;
                }
            },
            hint: 'Подтверждение пароля создаваемого пользователя.',
        );


        try {
            $userDTO = new CreateUserDTO(
                full_name: $fullName,
                login: $login,
                password: $password,
                password_confirmation: $passwordConfirmation
            );
            progress(
                label: 'Создание пользователя',
                steps: 1,
                callback: fn () => $userService->store(
                    userDTO: $userDTO,
                    userBalanceService: app()->make(UserBalanceServiceInterface::class)
                )
            );
            $this->info("Пользователь {$login} успешно добавлен");
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }

    }
}
