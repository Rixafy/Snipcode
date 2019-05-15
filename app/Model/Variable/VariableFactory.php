<?php

declare(strict_types=1);

namespace Snipcode\Model\Variable;

class VariableFactory
{
	public function create(VariableData $variableData): Variable
	{
		return new Variable($variableData);
	}
}
