<?php

declare(strict_types=1);

namespace CodePix\System\Application\UseCases\Transaction;

use BRCas\CA\Exceptions\DomainNotFoundException;
use CodePix\System\Application\Repository\TransactionRepository;
use CodePix\System\Domain\DomainTransaction;

class FindUseCase
{
    public function __construct(protected TransactionRepository $transactionRepository)
    {
        //
    }

    /**
     * @throws DomainNotFoundException
     */
    public function exec(string $id): DomainTransaction
    {
        return $this->transactionRepository->find($id) ?: throw new DomainNotFoundException(
            DomainTransaction::class,
            $id
        );
    }
}