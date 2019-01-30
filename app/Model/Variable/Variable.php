<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="variable")
 * @ORM\HasLifecycleCallbacks
 */
class Variable
{
    use UniqueTrait;
    use DateTimeTrait;

    /**
     * @ORM\Column(type="string", unique=true, length=31)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="integer", length=31)
     * @var int
     */
    private $value;

    /**
     * Constant constructor.
     * @param string $name
     * @param int $value
     */
    public function __construct(string $name, int $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $add
     */
    public function increaseValue(int $add = 1): void
    {
        $this->value += $add;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
