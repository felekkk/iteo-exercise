<?php

declare(strict_types=1);

namespace App\Core\Handler;

use App\Core\Service\Import\ValueObject\RepositoryInformation;

class SynchronizeRepositoryInformation
{
    public function __construct(public readonly RepositoryInformation $information)
    {
    }
}