<?php

namespace App\Console\Commands;

use App\DTO\CreateBalanceTransactionDTO;
use App\Jobs\BalanceTransactionJob;
use App\Models\BalanceTransaction;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\BalanceTransactionService;
use Illuminate\Console\Command;
use function Laravel\Prompts\progress;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class CreateBalanceTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:transaction';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Проведение операций по балансу пользователя';

    /**
     * Execute the console command.
     */
    public function handle(UserRepositoryInterface $userRepository, BalanceTransactionService $balanceTransactionService)
    {

        $login = select(
            label: 'Выбор пользователя',
            options: $userRepository->getAll()->pluck('login')
        );

        $transactionType = select(
            label: 'Выберите тип операции.',
            options: BalanceTransaction::ALLOWABLE_TYPES,
            hint: 'Логин создаваемого пользователя.',
        );

        $description = text(
            label: 'Введите описание транзакции.',
            required: 'Описание транзакции обязательно к заполнению.',
            validate: fn(string $value) => match (true) {
                strlen($value) < 6 => 'Описание должно быть не короче 6 символов.',
                strlen($value) > 100 => 'Описание должно быть не длинее 100 символов.',
                default => null
            },
            hint: 'Описание производимой транзакции.',
        );
        $user = null;
        $amount = text(
            label: 'Введите сумму.',
            required: 'Сумма обязательна к заполнению.',
            validate: function(float $value) use(&$user, $transactionType, $login, $userRepository) {
                $user = $userRepository->getByLogin($login);
                return match (true) {
                    $value <= 0 => 'Сумма должна быть больше 0',
                    $transactionType === BalanceTransaction::TYPE_DEBIT
                        && (bcsub($user->userBalance->balance, $value) <= 0)
                            => "Недостаточно средств. Пополните баланс на ". abs(bcsub($user->userBalance->balance, $value))
                                . ' ед. ' . "Количество средств на счету {$user->userBalance->balance}",
                    default => null
                };
            },
            hint: 'Сумма операции.',
        );


        try {
            $createBalanceTransactionDTO = new CreateBalanceTransactionDTO(
                user_id: $user->id,
                type: $transactionType,
                amount: $amount,
                description: $description
            );
            BalanceTransactionJob::dispatch(
                balanceTransactionService: $balanceTransactionService,
                balanceTransactionDTO: $createBalanceTransactionDTO
            )->onQueue('transactions');
            $this->info("Транзакция {$transactionType} для пользователя {$login} успешно отправлена на обработку");
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
