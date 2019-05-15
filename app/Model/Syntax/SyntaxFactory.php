<?php

declare(strict_types=1);

namespace Snipcode\Model\Syntax;

class SyntaxFactory
{
	public function create(SyntaxData $syntaxData): Syntax
	{
		return new Syntax($syntaxData);
	}
}
