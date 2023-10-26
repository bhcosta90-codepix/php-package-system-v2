<?php

declare(strict_types=1);

namespace Tests\Stubs;

use BRCas\CA\Contracts\Event\EventManagerInterface;
use Costa\Entity\Contracts\EventInterface;

class EventManager implements EventManagerInterface
{
    public function dispatch(array $events): void
    {
        dump($events);
    }

}