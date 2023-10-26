<?php

declare(strict_types=1);

namespace CodePix\System\Domain;

use CodePix\System\Domain\Enum\EnumPixType;
use Costa\Entity\Data;

class DomainPixKey extends Data
{
    public function __construct(
        protected EnumPixType $kind,
        protected string $key,
    ) {
        parent::__construct();
    }
}