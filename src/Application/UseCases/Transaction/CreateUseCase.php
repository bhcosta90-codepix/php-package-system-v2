<?php

declare(strict_types=1);

namespace CodePix\System\Application\UseCases\Transaction;

use BRCas\CA\Exceptions\DomainNotFoundException;
use BRCas\CA\Exceptions\UseCaseException;
use CodePix\System\Application\Repository\PixKeyRepository;
use CodePix\System\Application\Repository\TransactionRepository;
use CodePix\System\Domain\DomainPixKey;
use CodePix\System\Domain\DomainTransaction;
use CodePix\System\Domain\Enum\EnumPixType;
use Costa\Entity\Exceptions\NotificationException;
use Costa\Entity\ValueObject\Uuid;

class CreateUseCase
{
    public function __construct(
        protected PixKeyRepository $pixKeyRepository,
        protected TransactionRepository $transactionRepository
    ) {
        //
    }

    /**
     * @throws DomainNotFoundException
     * @throws UseCaseException
     * @throws NotificationException
     */
    public function exec(string $bank, string $id, string $description, float $value, string $kind, string $key): DomainTransaction
    {
        $kind = EnumPixType::from($kind);

        if (!$pix = $this->pixKeyRepository->find($kind, $key)) {
            throw new DomainNotFoundException(
                DomainPixKey::class,
                "kind: {$kind->value} and key: {$key}"
            );
        }

        $response = new DomainTransaction(
            bank: new Uuid($bank),
            reference: new Uuid($id),
            description: $description,
            value: $value,
            pix: $pix,
        );

        return $this->transactionRepository->create($response) ?: throw new UseCaseException(
            "We were unable to register this transaction in our database"
        );
    }
}