<?php

declare(strict_types=1);

use CodePix\System\Application\UseCases\Transaction\Status\ConfirmedUseCase;
use CodePix\System\Domain\DomainTransaction;
use CodePix\System\Domain\Enum\EnumTransactionStatus;
use Tests\Stubs\EventManager;
use Tests\Stubs\Repository\TransactionRepository;

use function PHPUnit\Framework\assertEquals;
use function Tests\arrayDomainTransaction;


describe("ConfirmedUseCase Feature Test", function () {
    test("save a transaction", function () {
        $transaction = new DomainTransaction(...arrayDomainTransaction());
        $transaction->pending();

        $transactionRepository = new TransactionRepository();
        $transactionRepository->create($transaction);

        $useCase = new ConfirmedUseCase(
            transactionRepository: $transactionRepository, eventManager: new EventManager()
        );
        $response = $useCase->exec($transaction->id());
        assertEquals(EnumTransactionStatus::CONFIRMED, $response->status);
    });
});