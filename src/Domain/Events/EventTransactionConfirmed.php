<?php

declare(strict_types=1);

namespace CodePix\System\Domain\Events;

use Costa\Entity\Contracts\EventInterface;
use Costa\Entity\ValueObject\Uuid;

class EventTransactionConfirmed implements EventInterface
{
    public function __construct(protected Uuid $bank, protected Uuid $id)
    {
        //
    }

    public function payload(): array
    {
        return [
            'bank' => (string)$this->bank,
            'id' => (string)$this->id,
        ];
    }
}