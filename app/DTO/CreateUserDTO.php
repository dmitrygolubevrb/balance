<?php


namespace App\DTO;


use Illuminate\Support\Facades\Validator;

class CreateUserDTO
{

    public function __construct(
        public string $full_name,
        public string $login,
        public string $password,
        public string $password_confirmation
    )
    {}


    public function getValidatedData(): array
    {
        return Validator::make(get_object_vars($this), [
            'full_name' => 'required|string|max:60',
            'login' => 'required|string|unique:users,login|max:60',
            'password' => 'required|confirmed|string|max:60'
        ],
        [
            'required' => 'Аттрибут :attribute обязателен к заполнению',
            'confirmed' => 'Пароль не подтвержден'
        ])->validated();
    }

}
