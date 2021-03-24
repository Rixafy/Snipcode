<?php

declare(strict_types=1);

namespace App\Model\Hashids;

use Hashids\Hashids;

class HashidsProvider
{
    private Hashids $hashids;
    
    public function __construct(
        private string $salt
    ) {
        $this->hashids = new Hashids(salt: $this->salt, minHashLength: 8);
    }
    
    public function provide(): Hashids
    {
        return $this->hashids;
    }
}
