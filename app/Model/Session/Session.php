<?php

declare(strict_types=1);

namespace App\Model\Session;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Rixafy\DoctrineTraits\DateTimeTrait;
use Rixafy\IpAddress\IpAddress;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="session", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"hash"})
 * })
 */
class Session
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary", unique=true)
     */
    private UuidInterface $id;

    /** @ORM\Column(type="string", length=26, unique=true) */
    private string $hash;

    /** @ORM\Column(type="boolean") */
    private bool $isCrawler;

    /** @ORM\Column(type="string", length=63, nullable=true) */
    private ?string $crawlerName;

    /** @ORM\ManyToOne(targetEntity="\Rixafy\IpAddress\IpAddress", inversedBy="session", cascade={"persist"}) */
    private IpAddress $ipAddress;

    use DateTimeTrait;

    public function __construct(UuidInterface $id, SessionData $data)
    {
        $this->id = $id;
        $this->hash = $data->hash;
        $this->isCrawler = $data->isCrawler;
        $this->crawlerName = $data->crawlerName;
        $this->edit($data);
    }

    public function edit(SessionData $data): void
    {
        $this->ipAddress = $data->ipAddress;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getData(): SessionData
    {
        $data = new SessionData();
        $data->ipAddress = $this->ipAddress;
        return $data;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function getIpAddress(): IpAddress
    {
        return $this->ipAddress;
    }

    public function isCrawler(): bool
    {
        return $this->isCrawler;
    }

    public function getCrawlerName(): string
    {
        return $this->crawlerName;
    }
}
