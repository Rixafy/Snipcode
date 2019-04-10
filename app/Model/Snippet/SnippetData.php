<?php

declare(strict_types=1);

namespace App\Model\Snippet;

use App\Entity\IpAddress;
use App\Entity\Session;
use App\Entity\Syntax;
use DateTime;

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