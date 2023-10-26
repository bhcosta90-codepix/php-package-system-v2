<?php

declare(strict_types=1);

namespace CodePix\System\Domain;

use CodePix\System\Domain\Enum\EnumTransactionStatus;
use Costa\Entity\Data;

class DomainTransaction extends Data
{
    protected EnumTransactionStatus $status = EnumTransactionStatus::PENDING;

    public function __construct(
        protected string $description,
        protected float $value,
        protected DomainPixKey $pix,
    ) {
        parent::__construct();
    }

    protected function rules(): array
    {
        return [
            'value' => 'numeric|min:0.01',
            'description' => 'min:3',
        ];
    }
}