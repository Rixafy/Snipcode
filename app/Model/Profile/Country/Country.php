<?php declare(strict_types=1);

namespace Snipcode\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="country")
 */
class Country
{
    use UniqueTrait;

    /**
     * @ORM\Column(type="string", unique=true)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=3)
     * @var string
     */
    protected $code_currency;

    /**
     * @ORM\Column(type="string", length=2)
     * @var string
     */
    protected $code_continent;

    /**
     * @ORM\Column(type="string", length=2, unique=true)
     * @var string
     */
    protected $code_alpha2;

    /**
     * @ORM\Column(type="string", length=5)
     * @var string
     */
    protected $code_language;

    /**
     * Country constructor.
     * @param string $name
     * @param string $code_currency
     * @param string $code_continent
     * @param string $code_alpha2
     * @param string $code_language
     */
    public function __construct(string $name, string $code_currency, string $code_continent, string $code_alpha2, string $code_language)
    {
        $this->name = $name;
        $this->code_currency = $code_currency;
        $this->code_continent = $code_continent;
        $this->code_alpha2 = $code_alpha2;
        $this->code_language = $code_language;
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
    public function getCodeCurrency(): string
    {
        return $this->code_currency;
    }

    /**
     * @return string
     */
    public function getCodeAlpha2(): string
    {
        return $this->code_alpha2;
    }

    /**
     * @return string
     */
    public function getCodeLanguage(): string
    {
        return $this->code_language;
    }

    /**
     * @return string
     */
    public function getCodeContinent(): string
    {
        return $this->code_continent;
    }
}