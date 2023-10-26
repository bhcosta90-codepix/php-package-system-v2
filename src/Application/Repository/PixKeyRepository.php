<?php

declare(strict_types=1);

namespace CodePix\System\Application\Repository;

use CodePix\System\Domain\DomainPixKey;
use CodePix\System\Domain\Enum\EnumPixType;

interface PixKeyRepository
{
    public function find(EnumPixType $type, string $key): ?DomainPixKey;

    public function create(DomainPixKey $entity): ?DomainPixKey;
}