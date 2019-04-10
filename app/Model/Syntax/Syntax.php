<?php declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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

    /**
     * Syntax constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getShortName(): string
    {
        return $this->short_name;
    }

    /**
     * @param string $short_name
     */
    public function setShortName(string $short_name): void
    {
        $this->short_name = $short_name;
    }
}
