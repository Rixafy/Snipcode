<?php

declare(strict_types=1);

namespace Snipcode\Model\Syntax;

use Doctrine\ORM\Mapping as ORM;
use Snipcode\Entity\UniqueTrait;

/**
 * @ORM\Entity
 * @ORM\Table(name="syntax")
 */
class Syntax
{
    use UniqueTrait;

    /**
     * @ORM\Column(type="string", unique=true, length=63)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", unique=true, length=31)
     * @var string
     */
    protected $short_name;

    public function __construct(SyntaxData $syntaxData)
    {
        $this->name = $syntaxData->name;
        $this->short_name = $syntaxData->shortName;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getShortName(): string
    {
        return $this->short_name;
    }
}
