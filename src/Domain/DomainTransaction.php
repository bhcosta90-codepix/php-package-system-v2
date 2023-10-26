<?php

declare(strict_types=1);

namespace CodePix\System\Domain;

use CodePix\System\Domain\Enum\EnumTransactionStatus;
use Costa\Entity\Data;

class DomainTransaction extends Data
{
    protected EnumTransactionStatus $status = EnumTransactionStatus::PENDING;

    protected ?string $cancelDescription = null;

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

    public function error(string $message): void
    {
        $this->cancelDescription = $message;
        $this->status = EnumTransactionStatus::ERROR;
    }
}