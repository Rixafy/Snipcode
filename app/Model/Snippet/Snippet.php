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
	protected $slugHelper;

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
	 * @ORM\ManyToOne(targetEntity="\Snipcode\Entity\Session", inversedBy="snippet", cascade={"persist"})
	 * @var Session
	 */
	protected $authorSession;

	/**
	 * @ORM\ManyToOne(targetEntity="\Snipcode\Entity\IpAddress", inversedBy="snippet", cascade={"persist"})
	 * @var IpAddress
	 */
	protected $authorIpAddress;

	/**
	 * @ORM\ManyToOne(targetEntity="\Snipcode\Model\Syntax\Syntax", inversedBy="snippet", cascade={"persist"})
	 * @var Syntax
	 */
	protected $syntax;

	/**
	 * @ORM\Column(type="datetime", nullable=true)
	 * @var DateTime
	 */
	protected $expireAt;

	public function __construct(SnippetData $snippetData)
	{
		$this->edit($snippetData);
		$this->authorSession->addSnippet($this);
	}

	public function edit(SnippetData $snippetData): void
	{
		$this->title = $snippetData->title;
		$this->payload = $snippetData->payload;
		$this->authorSession = $snippetData->authorSession;
		$this->authorIpAddress = $snippetData->authorIpAddress;
		$this->syntax = $snippetData->syntax;
		$this->expireAt = $snippetData->expireAt;
	}

	public function getData(): SnippetData
	{
		$data = new SnippetData();

		$data->title = $this->title;
		$data->payload = $this->payload;
		$data->authorSession = $this->authorSession;
		$data->authorIpAddress = $this->authorIpAddress;
		$data->syntax = $this->syntax;
		$data->expireAt = $this->expireAt;

		return $data;
	}

	public function getSlug(): string
	{
		return $this->slug;
	}

	public function createSlug(int $slugHelper, string $slug): void
	{
		$this->slugHelper = $slugHelper;
		$this->slug = $slug;
	}

	public function getPayload(): string
	{
		return $this->payload;
	}

	public function getAuthorSession(): Session
	{
		return $this->authorSession;
	}

	public function getAuthorIpAddress(): IpAddress
	{
		return $this->authorIpAddress;
	}

	public function getSyntax(): Syntax
	{
		return $this->syntax;
	}

	public function getSlugHelper(): int
	{
		return $this->slugHelper;
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
