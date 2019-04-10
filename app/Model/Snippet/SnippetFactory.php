<?php

declare(strict_types=1);

namespace App\Model\Snippet;

class SnippetFactory
{
	public function create(SnippetData $snippetData): Snippet
	{
		return new Snippet($snippetData);
	}
}