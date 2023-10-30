<?php

declare(strict_types=1);

namespace CodePix\System\Domain;

use CodePix\System\Domain\Enum\EnumPixType;
use CodePix\System\ValueObject\Document;
use Costa\Entity\Data;
use Costa\Entity\Exceptions\EntityException;
use Costa\Entity\Exceptions\NotificationException;
use Costa\Entity\ValueObject\Uuid;

class DomainPixKey extends Data
{
    /**
     * @throws EntityException
     * @throws NotificationException
     */
    public function __construct(
        protected Uuid $bank,
        protected EnumPixType $kind,
        protected ?string $key,
    ) {
        if ($this->kind == EnumPixType::ID && empty($this->key)) {
            $this->key = (string)Uuid::make();
        }

        if ($this->kind == EnumPixType::DOCUMENT) {
            $this->key = (string)new Document(preg_replace('/[^0-9]/', '', $this->key));
        }

        parent::__construct();
    }

    protected function rules(): array
    {
        return [
            'key' => 'required',
        ];
    }
}