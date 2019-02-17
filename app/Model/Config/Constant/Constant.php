<?php declare(strict_types=1);

namespace App\Entity;

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
    private $name;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $value;

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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

    /**
     * @param int $value
     */
    public function setIntValue(int $value): void
    {
        $this->value = strval($value);
    }

    /**
     * @param bool $value
     */
    public function setBoolValue(bool $value): void
    {
        $this->value = strval($value);
    }

    /**
     * @return bool
     */
    public function getBoolValue(): bool
    {
        return boolval($this->value);
    }

    /**
     * @return int
     */
    public function getIntValue(): int
    {
        return intval($this->value);
    }
}
