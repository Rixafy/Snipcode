<?php

declare(strict_types=1);

namespace App\Model\Syntax;

use Ramsey\Uuid\Uuid;

final class SyntaxFactory
{
    public function create(SyntaxData $data): Syntax
    {
        return new Syntax(Uuid::uuid4(), $data);
    }
}
