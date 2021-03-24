<?php

declare(strict_types=1);

namespace App\Model\Snippet;

use Ramsey\Uuid\Uuid;

final class SnippetFactory
{
	public function create(SnippetData $data): Snippet
	{
		return new Snippet(Uuid::uuid4(), $data);
	}
}
