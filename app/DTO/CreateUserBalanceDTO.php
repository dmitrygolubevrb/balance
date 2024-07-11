<?php


namespace App\DTO;


use Illuminate\Support\Facades\Validator;

class CreateUserBalanceDTO
{

    public function __construct(
        public int $user_id,
    )
    {}


    public function getValidatedData(): array
    {
        return Validator::make(get_object_vars($this), [
            'user_id' => 'required|int|exists:users,id'
        ],
        [
            'required' => 'Аттрибут :attribute обязателен к заполнению',
            'int' => 'Аттрибут :attribute должен быть целым числом',
            'exists' => 'Пользователь с таким id не найден'
        ])->validated();
    }

}
