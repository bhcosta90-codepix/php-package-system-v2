<?php

declare(strict_types=1);

use CodePix\System\Application\UseCases\PixKey\CreateUseCase;
use CodePix\System\Domain\DomainPixKey;
use Tests\Stubs\Repository\PixKeyRepository;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotNull;

describe("CreateUseCase Feature Test", function () {
    test("create with data", function () {
        $useCase = new CreateUseCase(pixKeyRepository: new PixKeyRepository());
        $response = $useCase->exec("3c05a2c6-5ebe-4dee-9460-3ba5cade0992", "email", "test@test.com");
        assertInstanceOf(DomainPixKey::class, $response);
    });

    test("create with id without key", function () {
        $useCase = new CreateUseCase(pixKeyRepository: new PixKeyRepository());
        $response = $useCase->exec("3c05a2c6-5ebe-4dee-9460-3ba5cade0992", "id", null);
        assertInstanceOf(DomainPixKey::class, $response);
        assertNotNull($response->key);
    });
});