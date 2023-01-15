<?php

declare(strict_types=1);


namespace App\Shared\Domain\Service;

use Symfony\Component\Uid\Ulid;

class UlidService
{
    public static function generateUlid(): string
    {
        return Ulid::generate();
    }
}