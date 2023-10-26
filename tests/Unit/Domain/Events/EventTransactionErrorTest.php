<?php

declare(strict_types=1);

use CodePix\System\Domain\DomainTransaction;

use CodePix\System\Domain\Events\EventTransactionCreating;

use CodePix\System\Domain\Events\EventTransactionError;

use Costa\Entity\ValueObject\Uuid;

use function PHPUnit\Framework\assertEquals;
use function Tests\dataDomainTransaction;
use function Tests\mockTimes;

describe("EventTransactionCreating Unit Test", function(){
    test("payload", function(){
        $event = new EventTransactionError($id = Uuid::make(), "test");
        assertEquals([
            'bank' => $id,
            'id' => 'test'
        ], $event->payload());
    });
});