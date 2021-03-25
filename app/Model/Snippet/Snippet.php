<?php

declare(strict_types=1);

namespace App\Model\Snippet;

use App\Model\Session\Session;
use App\Model\Syntax\Syntax;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Rixafy\IpAddress\IpAddress;

/**
 * @ORM\Entity
 * @ORM\Table(name="snippet", indexes={
 *     @ORM\Index(name="slug", columns={"slug"}),
 *     @ORM\Index(name="encoded_number", columns={"encoded_number"}),
 *     @ORM\Index(name="created_at", columns={"created_at"}),
 *     @ORM\Index(name="expire_at", columns={"expire_at"})
 * })
 */
class Snippet
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid_binary", unique=true)
     */
    private UuidInterface $id;

    /** @ORM\Column(type="string", nullable=true) */
    private ?string $title;

    /** @ORM\Column(type="string", options={"collation":"utf8_bin"}) */
    private string $slug;

    /** @ORM\Column(type="integer") */
    private int $encodedNumber;

    /** @ORM\Column(type="text") */
    private string $payload;

    /** @ORM\Column(type="integer") */
    private int $views = 0;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Model\Snippet\Snippet")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private ?Snippet $forkedFrom;

    /**
     * @ORM\ManyToOne(targetEntity="\App\Model\Session\Session")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private Session $session;

    /**
     * @ORM\ManyToOne(targetEntity="\Rixafy\IpAddress\IpAddress")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private IpAddress $ipAddress;

    /** @ORM\ManyToOne(targetEntity="\App\Model\Syntax\Syntax") */
    private ?Syntax $syntax;

    /** @ORM\Column(type="datetime") */
    private DateTime $createdAt;

    /** @ORM\Column(type="datetime") */
    private DateTime $expireAt;

    public function __construct(UuidInterface $id, SnippetData $data)
    {
        $this->id = $id;
        $this->createdAt = new DateTime();
        $this->forkedFrom = $data->forkedFrom;
        $this->session = $data->session;
        $this->ipAddress = $data->ipAddress;
        $this->slug = $data->slug;
        $this->encodedNumber = $data->encodedNumber;
        $this->edit($data);
    }

    public function edit(SnippetData $data): void
    {
        $this->title = $data->title;
        $this->payload = $data->payload;
        $this->syntax = $data->syntax;
        $this->expireAt = $data->expireAt;
    }

    public function getData(): SnippetData
    {
        $data = new SnippetData();
        $data->title = $this->title;
        $data->payload = $this->payload;
        $data->syntax = $this->syntax;
        $data->expireAt = $this->expireAt;

        return $data;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title == null ? 'Snippet #'.$this->getSlug() : $this->title;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getEncodedNumber(): int
    {
        return $this->encodedNumber;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getViews(): int
    {
        return $this->views;
    }

    public function getForkedFrom(): ?Snippet
    {
        return $this->forkedFrom;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function getIpAddress(): IpAddress
    {
        return $this->ipAddress;
    }

    public function getSyntax(): Syntax
    {
        return $this->syntax;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getExpireAt(): DateTime
    {
        return $this->expireAt;
    }
}
