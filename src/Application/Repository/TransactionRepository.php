<?php

declare(strict_types=1);

namespace CodePix\System\Application\Repository;

use CodePix\System\Domain\DomainTransaction;

interface TransactionRepository
{
    public function find(string $id): ?DomainTransaction;

    public function create(DomainTransaction $entity): ?DomainTransaction;

    public function save(DomainTransaction $entity): ?DomainTransaction;
}