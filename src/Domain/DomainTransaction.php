<?php

declare(strict_types=1);

namespace CodePix\System\Domain;

use CodePix\System\Domain\Enum\EnumTransactionStatus;
use Costa\Entity\Data;
use Costa\Entity\Exceptions\EntityException;
use Costa\Entity\ValueObject\Uuid;

class DomainTransaction extends Data
{
    protected EnumTransactionStatus $status = EnumTransactionStatus::PENDING;

    protected ?string $cancelDescription = null;

    public function __construct(
        protected Uuid $bank,
        protected Uuid $reference,
        protected string $description,
        protected float $value,
        protected DomainPixKey $pix,
    ) {
        parent::__construct();
    }

    public function error(string $message): self
    {
        $this->cancelDescription = $message;
        $this->status = EnumTransactionStatus::ERROR;
        return $this;
    }

    /**
     * @throws EntityException
     */
    public function confirmed(): self
    {
        if ($this->status === EnumTransactionStatus::PENDING) {
            $this->status = EnumTransactionStatus::CONFIRMED;
            return $this;
        }

        throw new EntityException('Only pending transaction can be confirmed');
    }

    /**
     * @throws EntityException
     */
    public function completed(): self
    {
        if ($this->status === EnumTransactionStatus::CONFIRMED) {
            $this->status = EnumTransactionStatus::COMPLETED;
            return $this;
        }

        throw new EntityException('Only confirmed transactions can be completed');
    }

    protected function rules(): array
    {
        return [
            'value' => 'numeric|min:0.01',
            'description' => 'min:3',
        ];
    }
}