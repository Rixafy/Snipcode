<?php

declare(strict_types=1);

namespace App\Model\Syntax;

final class SyntaxData
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
