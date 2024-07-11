<?php


namespace App\DTO;


use App\Models\BalanceTransaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateBalanceTransactionDTO
{

    public function __construct(
        public int $user_id,
        public string $type,
        public float $amount,
        public string $description,
    )
    {}


    public function getValidatedData(): array
    {
        return Validator::make(get_object_vars($this), [
            'user_id' => 'required|int|exists:users,id',
            'type' => [
                'required',
                'string',
                Rule::in(BalanceTransaction::ALLOWABLE_TYPES)
            ],
            'amount' => 'required|decimal:0,4',
            'description' => 'required|string|min:6|max:100'
        ],
        [
            'in' => 'Значение :attribute должно быть разрешенным типом транзакции',
            'required' => 'Аттрибут :attribute обязателен к заполнению',
            'decimal' => 'Число должно быть decimal'
        ])->validated();
    }

}
