<?php

declare(strict_types=1);

namespace CodePix\System\Domain;

use Costa\Entity\Data;

class DomainTransaction extends Data
{
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