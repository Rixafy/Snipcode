<?php

declare(strict_types=1);

namespace Snipcode\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="constant")
 */
class Constant
{
    use UniqueTrait;

    /**
     * @ORM\Column(type="string", unique=true, length=31)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $value;

    /**
     * Constant constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    public function setIntValue(int $value): void
    {
        $this->value = strval($value);
    }

    public function setBoolValue(bool $value): void
    {
        $this->value = strval($value);
    }

    public function getBoolValue(): bool
    {
        return boolval($this->value);
    }

    public function getIntValue(): int
    {
        return intval($this->value);
    }
}
