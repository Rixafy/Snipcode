<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="snippet", indexes={@ORM\Index(name="search_index", columns={"slug"})})
 * @ORM\HasLifecycleCallbacks
 */
class Snippet
{
    use UniqueTrait;
    use DateTimeTrait;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $slug;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $slug_helper;

    /**
     * @ORM\Column(type="text")
     * @var string
     */
    private $payload;

    /**
     * Many Snippets have One Session
     * @ORM\ManyToOne(targetEntity="Session", inversedBy="snippet", cascade={"persist"})
     * @var Session
     */
    private $author_session;

    /**
     * Many Snippets have One IpAddress
     * @ORM\ManyToOne(targetEntity="IpAddress", inversedBy="snippet", cascade={"persist"})
     * @var IpAddress
     */
    private $author_ip_address;

    /**
     * Many Snippets have One Syntax
     * @ORM\ManyToOne(targetEntity="Syntax", inversedBy="snippet", cascade={"persist"})
     * @var Syntax
     */
    private $syntax;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    private $expire_at;

    /**
     * Snippet constructor.
     * @param string $title
     * @param string $payload
     * @param Session $author_session
     * @param IpAddress $author_ip_address
     * @param Syntax $syntax
     * @param DateTime|null $expire_at
     */
    public function __construct(?string $title, string $payload, Session $author_session, IpAddress $author_ip_address, Syntax $syntax, DateTime $expire_at = null)
    {
        $this->title = $title;
        $this->payload = $payload;
        $this->author_session = $author_session;
        $this->author_ip_address = $author_ip_address;
        $this->syntax = $syntax;
        $this->expire_at = $expire_at;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     */
    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getPayload(): string
    {
        return $this->payload;
    }

    /**
     * @param string $payload
     */
    public function setPayload(string $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * @return Session
     */
    public function getAuthorSession(): Session
    {
        return $this->author_session;
    }

    /**
     * @return IpAddress
     */
    public function getAuthorIpAddress(): IpAddress
    {
        return $this->author_ip_address;
    }

    /**
     * @return Syntax
     */
    public function getSyntax(): Syntax
    {
        return $this->syntax;
    }

    /**
     * @param Syntax $syntax
     */
    public function setSyntax(Syntax $syntax): void
    {
        $this->syntax = $syntax;
    }

    /**
     * @return int
     */
    public function getSlugHelper(): int
    {
        return $this->slug_helper;
    }

    /**
     * @param int $slug_helper
     */
    public function setSlugHelper(int $slug_helper): void
    {
        $this->slug_helper = $slug_helper;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}