<?php

declare(strict_types=1);

use CodePix\System\Domain\DomainTransaction;
use Costa\Entity\Exceptions\NotificationException;

use function PHPUnit\Framework\assertEquals;
use function Tests\dataDomainPixKey;

beforeEach(fn() => $this->pix = dataDomainPixKey());

describe("DomainTransaction Unit Tests", function () {
    test("creating a new transaction", function () {
        $transaction = new DomainTransaction(
            description: 'testing',
            value: 50,
            pix: $this->pix,
        );

        assertEquals([
            'description' => 'testing',
            'value' => 50,
            'pix' => $this->pix->toArray(),
            'id' => $transaction->id(),
            'created_at' => $transaction->createdAt(),
            'updated_at' => $transaction->updatedAt(),
        ], $transaction->toArray());
    });

    test("making a transaction", function () {
        $transaction = DomainTransaction::make([
            'description' => 'testing',
            'value' => 50,
            'pix' => $this->pix,
            'id' => '4393e8bc-73f7-11ee-b962-0242ac120002',
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ]);

        assertEquals([
            'description' => 'testing',
            'value' => 50,
            'pix' => $this->pix->toArray(),
            'id' => '4393e8bc-73f7-11ee-b962-0242ac120002',
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ], $transaction->toArray());

        $transaction = DomainTransaction::make([
            'description' => 'testing',
            'value' => 50,
            'pix' => $this->pix,
            'id' => '4393e8bc-73f7-11ee-b962-0242ac120002',
            'createdAt' => '2020-01-01 00:00:00',
            'updatedAt' => '2020-01-01 00:00:00',
        ]);

        assertEquals([
            'description' => 'testing',
            'value' => 50,
            'pix' => $this->pix->toArray(),
            'id' => '4393e8bc-73f7-11ee-b962-0242ac120002',
            'created_at' => '2020-01-01 00:00:00',
            'updated_at' => '2020-01-01 00:00:00',
        ], $transaction->toArray());
    });

    describe("validation a entity", function () {
        test("validate property value", function () {
            expect(fn() => new DomainTransaction(
                description: 'testing',
                value: 0,
                pix: $this->pix,
            ))->toThrow(NotificationException::class);
        });

        test("validate property description", function () {
            expect(fn() => new DomainTransaction(
                description: 'te',
                value: 0.01,
                pix: $this->pix,
            ))->toThrow(NotificationException::class);
        });
    });
});