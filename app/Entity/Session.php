<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="session", indexes={@ORM\Index(name="search_index", columns={"hash"})})
 * @ORM\HasLifecycleCallbacks
 */
class Session
{
    use UniqueTrait;
    use DateTimeTrait;

    /**
     * @ORM\Column(type="string", length=26, unique=true)
     * @var string
     */
    private $hash;

    /**
     * Many Sessions have IpAddress
     * @ORM\ManyToOne(targetEntity="IpAddress", inversedBy="session", cascade={"persist"})
     * @var IpAddress
     */
    private $ip_address;

    /**
     * Session constructor.
     * @param string $hash
     * @param IpAddress $ip_address
     */
    public function __construct(string $hash, IpAddress $ip_address)
    {
        $this->hash = $hash;
        $this->ip_address = $ip_address;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @return IpAddress
     */
    public function getIpAddress(): IpAddress
    {
        return $this->ip_address;
    }

    /**
     * @param IpAddress $ip_address
     */
    public function changeIpAddress(IpAddress $ip_address): void
    {
        $this->ip_address = $ip_address;
    }
}