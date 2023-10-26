<?php

declare(strict_types=1);

use BRCas\CA\Exceptions\DomainNotFoundException;
use BRCas\CA\Exceptions\UseCaseException;
use CodePix\System\Application\Repository\PixKeyRepository;
use CodePix\System\Application\Repository\TransactionRepository;
use CodePix\System\Application\UseCases\Transaction\CreateUseCase;
use CodePix\System\Domain\DomainPixKey;

use function Tests\dataDomainPixKey;
use function Tests\dataDomainTransaction;
use function Tests\mockTimes;

describe("CreateUseCase Unit Test", function () {
    test("create a new entity", function () {
        $pixKeyRepository = mock(PixKeyRepository::class);
        mockTimes($pixKeyRepository, "find", dataDomainPixKey());

        $transactionRepository = mock(TransactionRepository::class);
        mockTimes($transactionRepository, "create", dataDomainTransaction());

        $useCase = new CreateUseCase(
            pixKeyRepository: $pixKeyRepository,
            transactionRepository: $transactionRepository,
        );

        $useCase->exec(
            "af4d8146-c829-46b6-8642-da0a0bdc2884",
            "9a439706-13ff-4a33-99ab-0bb80bb6b567",
            "testing",
            50,
            "email",
            "test@test.com"
        );
    });

    test("exception when to pix do not exist", function () {
        $pixKeyRepository = mock(PixKeyRepository::class);
        mockTimes($pixKeyRepository, "find");

        $transactionRepository = mock(TransactionRepository::class);

        $useCase = new CreateUseCase(
            pixKeyRepository: $pixKeyRepository,
            transactionRepository: $transactionRepository,
        );

        expect(
            fn() => $useCase->exec(
                "af4d8146-c829-46b6-8642-da0a0bdc2884",
                "9a439706-13ff-4a33-99ab-0bb80bb6b567",
                "testing",
                50,
                "email",
                "test@test.com"
            )
        )->toThrow(
            new DomainNotFoundException(DomainPixKey::class, "kind: email and key: test@test.com")
        );
    });

    test("exception when unable to register the transaction", function () {
        $pixKeyRepository = mock(PixKeyRepository::class);
        mockTimes($pixKeyRepository, "find", dataDomainPixKey());

        $transactionRepository = mock(TransactionRepository::class);
        mockTimes($transactionRepository, "create");

        $useCase = new CreateUseCase(
            pixKeyRepository: $pixKeyRepository,
            transactionRepository: $transactionRepository,
        );

        expect(
            fn() => $useCase->exec(
                "af4d8146-c829-46b6-8642-da0a0bdc2884",
                "9a439706-13ff-4a33-99ab-0bb80bb6b567",
                "testing",
                50,
                "email",
                "test@test.com"
            )
        )->toThrow(
            new UseCaseException("We were unable to register this transaction in our database")
        );
    });
});