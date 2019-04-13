<?php

declare(strict_types=1);

namespace Snipcode\Model\Snippet;

use Snipcode\Entity\DateTimeTrait;
use Snipcode\Entity\IpAddress;
use Snipcode\Entity\Session;
use Snipcode\Entity\UniqueTrait;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Snipcode\Model\Syntax\Syntax;

/**
 * @ORM\Entity
 * @ORM\Table(name="snippet", indexes={
 *	 @ORM\Index(name="search_index", columns={"slug"}),
 *	 @ORM\Index(name="updated_order", columns={"updated_at"}),
 *	 @ORM\Index(name="created_order", columns={"created_at"})
 * })
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
	protected $title;

	/**
	 * @ORM\Column(type="string", options={"collation":"utf8_bin"})
	 * @var string
	 */
	protected $slug;

	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	protected $slug_helper;

	/**
	 * @ORM\Column(type="text")
	 * @var string
	 */
	protected $payload;

	/**
	 * @ORM\Column(type="integer")
	 * @var int
	 */
	protected $views = 0;

	/**
	 * Many Snippets have One Session
	 * @ORM\ManyToOne(targetEntity="\Snipcode\Entity\Session", inversedBy="snippet", cascade={"persist"})
	 * @var Session
	 */
	protected $author_session;

	/**
	 * Many Snippets have One IpAddress
	 * @ORM\ManyToOne(targetEntity="\Snipcode\Entity\IpAddress", inversedBy="snippet", cascade={"persist"})
	 * @var IpAddress
	 */
	protected $author_ip_address;

	/**
	 * Many Snippets have One Syntax
	 * @ORM\ManyToOne(targetEntity="\Snipcode\Model\Syntax\Syntax", inversedBy="snippet", cascade={"persist"})
	 * @var Syntax
	 */
	protected $syntax;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @var DateTime
	 */
	protected $expire_at;

	public function __construct(SnippetData $snippetData)
	{
		$this->edit($snippetData);
		$this->author_session->addSnippet($this);
	}

	public function edit(SnippetData $snippetData): void
	{
		$this->title = $snippetData->title;
		$this->payload = $snippetData->payload;
		$this->author_session = $snippetData->authorSession;
		$this->author_ip_address = $snippetData->authorIpAddress;
		$this->syntax = $snippetData->syntax;
		$this->expire_at = $snippetData->expireAt;
	}

	public function getSlug(): string
	{
		return $this->slug;
	}

	public function createSlug(int $slugHelper, string $slug): void
	{
		$this->slug_helper = $slugHelper;
		$this->slug = $slug;
	}

	public function getPayload(): string
	{
		return $this->payload;
	}

	public function getAuthorSession(): Session
	{
		return $this->author_session;
	}

	public function getAuthorIpAddress(): IpAddress
	{
		return $this->author_ip_address;
	}

	public function getSyntax(): Syntax
	{
		return $this->syntax;
	}

	public function getSlugHelper(): int
	{
		return $this->slug_helper;
	}

	public function getTitle(): string
	{
		return $this->title == null ? 'Snippet #'.$this->getSlug() : $this->title;
	}

	public function getViews(): int
	{
		return $this->views;
	}

	public function addView(): void
	{
		$this->views++;
	}
}