<?php

declare(strict_types=1);

use CodePix\System\Domain\DomainTransaction;
use CodePix\System\Domain\Enum\EnumTransactionStatus;
use Costa\Entity\Exceptions\NotificationException;

use function PHPUnit\Framework\assertEquals;
use function Tests\dataDomainPixKey;

beforeEach(fn() => $this->pix = dataDomainPixKey());

describe("DomainTransaction Unit Tests", function () {
    test("creating a new transaction", function () {
        $entity = new DomainTransaction(
            description: 'testing',
            value: 50,
            pix: $this->pix,
        );

        assertEquals([
            'description' => 'testing',
            'value' => 50,
            'pix' => $this->pix->toArray(),
            'id' => $entity->id(),
            'created_at' => $entity->createdAt(),
            'updated_at' => $entity->updatedAt(),
            'status' => 'pending',
            'cancel_description' => null,
        ], $entity->toArray());
    });

    test("making a transaction", function () {
        $entity = DomainTransaction::make([
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
            'status' => 'pending',
            'cancel_description' => null,
        ], $entity->toArray());

        $entity = DomainTransaction::make([
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
            'status' => 'pending',
            'cancel_description' => null,
        ], $entity->toArray());

        $entity = DomainTransaction::make([
            'description' => 'testing',
            'value' => 50,
            'pix' => $this->pix,
            'status' => EnumTransactionStatus::from('confirmed'),
            'id' => '4393e8bc-73f7-11ee-b962-0242ac120002',
            'createdAt' => '2020-01-01 00:00:00',
            'updatedAt' => '2020-01-01 00:00:00',
        ]);

        assertEquals('confirmed', $entity->status->value);
    });

    test("setting a error at transaction", function(){
        $entity = new DomainTransaction(
            description: 'testing',
            value: 50,
            pix: $this->pix,
        );

        $entity->error('testing');
        assertEquals('error', $entity->status->value);
        assertEquals('testing', $entity->cancelDescription);
    });

    test("setting confirmation a transaction", function(){
        $entity = new DomainTransaction(
            description: 'testing',
            value: 50,
            pix: $this->pix,
        );
        $entity->confirmed();
        assertEquals('confirmed', $entity->status->value);
    });

    describe("validation an entity", function () {
        describe("at constructor", function(){
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

        describe("at make", function(){
            test("validate property value", function () {
                expect(fn() => DomainTransaction::make(
                    description: 'testing',
                    value: 0,
                    pix: $this->pix,
                ))->toThrow(NotificationException::class);
            });

            test("validate property description", function () {
                expect(fn() => DomainTransaction::make(
                    description: 'te',
                    value: 0.01,
                    pix: $this->pix,
                ))->toThrow(NotificationException::class);
            });
        });
    });
});