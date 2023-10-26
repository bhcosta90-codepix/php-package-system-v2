<?php

declare(strict_types=1);

namespace Tests;

use CodePix\System\Domain\DomainPixKey;
use CodePix\System\Domain\Enum\EnumPixType;
use Costa\Entity\ValueObject\Uuid;

function dataDomainPixKey(): DomainPixKey
{
    return new DomainPixKey(
        kind: EnumPixType::EMAIL,
        key: 'test@test.com',
    );
}

//function mockDomainTransaction(int $times = 1): DomainTransaction|MockInterface
//{
//    $response = Mockery::mock(DomainTransaction::class, [
//        "description" => 'testing',
//        "value" => 50,
//        "kind" => EnumPixType::EMAIL,
//        "key" => 'test@test.com',
//    ]);
//
//    $response->shouldReceive('toArray')->andReturn(dataMock() + [
//            "description" => 'testing',
//            "value" => 50,
//            "kind" => "email",
//            "key" => 'test@test.com',
//        ])->times($times);
//
//    return $response;
//}

function dataMock(): array
{
    return [
        'id' => (string)Uuid::make(),
        'created_at' => (new DateTime())->format('Y-m-d H:i:s'),
        'updated_at' => (new DateTime())->format('Y-m-d H:i:s'),
    ];
}