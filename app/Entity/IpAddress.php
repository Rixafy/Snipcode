<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="ip_address")
 */
class IpAddress
{
    use UniqueTrait;

    /**
     * @ORM\Column(type="string", unique=true, length=39)
     * @var string
     */
    private $address;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $domain_host;

    /**
     * @ORM\Column(type="boolean")
     * @var boolean
     */
    private $ipv6;

    /**
     * Many IpAddresses have One Country.
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="country", cascade={"persist"})
     * @var Country
     */
    private $country;

    /**
     * IpAddress constructor.
     * @param string $address
     * @param string $domain_host
     * @param bool $ipv6
     * @param Country $country
     */
    public function __construct(string $address, string $domain_host, bool $ipv6, Country $country)
    {
        $this->address = $address;
        $this->domain_host = $domain_host;
        $this->ipv6 = $ipv6;
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getDomainHost(): string
    {
        return $this->domain_host;
    }

    /**
     * @return bool
     */
    public function isIpv6(): bool
    {
        return $this->ipv6;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }
}