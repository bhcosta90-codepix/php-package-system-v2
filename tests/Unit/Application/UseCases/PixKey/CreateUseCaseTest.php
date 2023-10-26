<?php

declare(strict_types=1);

use BRCas\CA\Exceptions\DomainNotFoundException;
use CodePix\System\Application\Repository\PixKeyRepository;
use CodePix\System\Application\UseCases\PixKey\CreateUseCase;

use Costa\Entity\Exceptions\EntityException;

use function PHPUnit\Framework\assertEquals;
use function Tests\dataDomainPixKey;
use function Tests\mockTimes;

describe("CreateUseCase Unit Test", function () {
    test("get pix", function () {
        $pixKeyRepository = mock(PixKeyRepository::class);
        mockTimes($pixKeyRepository, 'find');
        mockTimes($pixKeyRepository, 'create', $verify = dataDomainPixKey());

        $useCase = new CreateUseCase(pixKeyRepository: $pixKeyRepository);
        $response = $useCase->exec('id', '7b9ad99b-7c44-461b-a682-b2e87e9c3c60');

        assertEquals($verify, $response);
    });

    test("exception when to register a pix that already exists", function(){
        $pixKeyRepository = mock(PixKeyRepository::class);
        mockTimes($pixKeyRepository, 'find', dataDomainPixKey());

        $useCase = new CreateUseCase(pixKeyRepository: $pixKeyRepository);
        expect(fn() => $useCase->exec('id', '7b9ad99b-7c44-461b-a682-b2e87e9c3c60'))->toThrow(new EntityException("This pix is already registered in our database"));
    });
});