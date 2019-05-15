<?php

declare(strict_types=1);

namespace Snipcode\Model\Snippet;

use Snipcode\Entity\IpAddress;
use Snipcode\Entity\Session;
use DateTime;
use Snipcode\Model\Syntax\Syntax;

class SnippetData
{
    /** @var string */
    public $title;

    /** @var string */
    public $payload;

    /** @var Session */
    public $authorSession;

    /** @var IpAddress */
    public $authorIpAddress;

    /** @var Syntax */
    public $syntax;

    /** @var DateTime */
    public $expireAt;
}
