<?php

declare(strict_types=1);

namespace App\Model\Variable;

class VariableFactory
{
	public function create(VariableData $variableData): Variable
	{
		return new Variable($variableData);
	}
}