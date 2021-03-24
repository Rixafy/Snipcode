<?php

declare(strict_types=1);

namespace App\Model\Snippet;

use App\Model\Session\Session;
use App\Model\Syntax\Syntax;
use DateTime;
use Rixafy\IpAddress\IpAddress;

final class SnippetData
{
	public ?string $title = null;
	public string $slug;
	public int $encodedNumber;
	public string $payload;
	public ?Snippet $forkedFrom = null;
	public Session $session;
	public IpAddress $ipAddress;
	public ?Syntax $syntax = null;
	public DateTime $expireAt;
}
