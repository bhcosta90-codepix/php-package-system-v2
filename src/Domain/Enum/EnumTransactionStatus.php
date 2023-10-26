<?php

declare(strict_types=1);

namespace CodePix\System\Domain\Enum;

enum EnumTransactionStatus: string
{
    case PENDING = 'pending';

    case CONFIRMED = 'confirmed';

    case COMPLETED = 'completed';

    case ERROR = 'error';
}
