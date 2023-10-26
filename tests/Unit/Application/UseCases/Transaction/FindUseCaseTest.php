<?php

declare(strict_types=1);

use BRCas\CA\Exceptions\DomainNotFoundException;
use CodePix\System\Application\Repository\TransactionRepository;
use CodePix\System\Application\UseCases\Transaction\FindUseCase;
use CodePix\System\Domain\DomainTransaction;

use function Tests\dataDomainTransaction;
use function Tests\mockTimes;

describe("FindUseCase Unit Test", function () {
    test("get pix", function () {
        $transactionRepository = mock(TransactionRepository::class);
        mockTimes($transactionRepository, 'find', dataDomainTransaction());

        $useCase = new FindUseCase(transactionRepository: $transactionRepository);
        $useCase->exec('7b9ad99b-7c44-461b-a682-b2e87e9c3c60');
    });

    test("exception when do not exist a pix", function () {
        $transactionRepository = mock(TransactionRepository::class);
        mockTimes($transactionRepository, 'find');

        $useCase = new FindUseCase(transactionRepository: $transactionRepository);
        expect(fn() => $useCase->exec('7b9ad99b-7c44-461b-a682-b2e87e9c3c60'))->toThrow(
            new DomainNotFoundException(DomainTransaction::class, "7b9ad99b-7c44-461b-a682-b2e87e9c3c60")
        );
    });
});