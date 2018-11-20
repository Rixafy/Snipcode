<?php

namespace App\Service;

use Hashids\Hashids;

class SlugGenerator
{
    /** @var string */
    protected $salt;

    /** @var Hashids */
    protected $hashIds;

    /**
     * Service constructor.
     * @param string $salt
     */
    public function __construct(string $salt)
    {
        $this->salt = $salt;
        $this->hashIds = new Hashids($salt);
    }

    /**
     * @param int $number
     * @return string
     */
    public function generateSlug(int $number): string
    {
        return $this->hashIds->encode($number);
    }
}