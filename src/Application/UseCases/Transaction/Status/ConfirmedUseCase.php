<?php

declare(strict_types=1);

namespace CodePix\System\Application\UseCases\Transaction\Status;

use BRCas\CA\Exceptions\DomainNotFoundException;
use BRCas\CA\Exceptions\UseCaseException;
use CodePix\System\Application\Repository\TransactionRepository;
use CodePix\System\Domain\DomainTransaction;
use Costa\Entity\Exceptions\EntityException;

class ConfirmedUseCase
{
    public function __construct(protected TransactionRepository $transactionRepository)
    {
        //
    }

    /**
     * @throws EntityException
     * @throws UseCaseException
     * @throws DomainNotFoundException
     */
    public function exec(string $id): DomainTransaction
    {
        $response = $this->transactionRepository->find($id) ?: throw new DomainNotFoundException(
            DomainTransaction::class,
            $id
        );

        $response->confirmed();

        return $this->transactionRepository->save($response) ?: throw new UseCaseException(
            "An error occurred while saving this transaction"
        );
    }
}