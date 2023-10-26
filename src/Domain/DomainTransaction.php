<?php

declare(strict_types=1);

namespace CodePix\System\Domain;

use CodePix\System\Domain\Enum\EnumPixType;
use Costa\Entity\Data;

class DomainTransaction extends Data
{
    public function __construct(
        protected string $description,
        protected float $value,
        protected EnumPixType $kind,
        protected string $key,
    ) {
        parent::__construct();
    }
}