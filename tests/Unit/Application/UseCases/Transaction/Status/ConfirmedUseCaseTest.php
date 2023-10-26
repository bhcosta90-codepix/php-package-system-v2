<?php

declare(strict_types=1);

use BRCas\CA\Exceptions\DomainNotFoundException;
use BRCas\CA\Exceptions\UseCaseException;
use CodePix\System\Application\Repository\TransactionRepository;
use CodePix\System\Application\UseCases\Transaction\Status\ConfirmedUseCase;
use CodePix\System\Domain\DomainTransaction;
use CodePix\System\Domain\Enum\EnumTransactionStatus;

use function PHPUnit\Framework\assertEquals;
use function Tests\dataDomainTransaction;
use function Tests\mockTimes;


describe("ConfirmedUseCase Unit Test", function () {
    test("save a transaction", function () {
        $transactionRepository = mock(TransactionRepository::class);
        mockTimes($transactionRepository, 'find', $entity = dataDomainTransaction());
        mockTimes($transactionRepository, 'save', $entity);

        $useCase = new ConfirmedUseCase(transactionRepository: $transactionRepository);
        $entity = $useCase->exec('7b9ad99b-7c44-461b-a682-b2e87e9c3c60');
        assertEquals($entity->status, EnumTransactionStatus::CONFIRMED);
    });

    test("exception when find a transaction", function () {
        $transactionRepository = mock(TransactionRepository::class);
        mockTimes($transactionRepository, 'find');

        $useCase = new ConfirmedUseCase(transactionRepository: $transactionRepository);
        expect(fn() => $useCase->exec('7b9ad99b-7c44-461b-a682-b2e87e9c3c60'))->toThrow(
            new DomainNotFoundException(DomainTransaction::class, "7b9ad99b-7c44-461b-a682-b2e87e9c3c60")
        );
    });

    test("exception when save a transaction", function () {
        $transactionRepository = mock(TransactionRepository::class);
        mockTimes($transactionRepository, 'find', dataDomainTransaction());
        mockTimes($transactionRepository, 'save');

        $useCase = new ConfirmedUseCase(transactionRepository: $transactionRepository);
        expect(fn() => $useCase->exec('7b9ad99b-7c44-461b-a682-b2e87e9c3c60'))->toThrow(
            new UseCaseException("An error occurred while saving this transaction")
        );
    });
});