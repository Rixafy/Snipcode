<?php

declare(strict_types=1);

namespace App\Model\Variable;

use App\Model\Variable\Exception\VariableNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class VariableRepository
{
	/** @var EntityManagerInterface */
	private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getRepository()
	{
		return $this->entityManager->getRepository(Variable::class);
	}

	/**
	 * @throws VariableNotFoundException
	 */
	public function get(UuidInterface $id): Variable
    {
    	/** @var Variable $variable */
    	$variable = $this->getRepository()->find($id);

    	if ($variable === null) {
    		throw new VariableNotFoundException('Variable with id ' . $id . ' not found.');
		}

        return $variable;
    }

	/**
	 * @throws VariableNotFoundException
	 */
    public function getByName(string $name): ?Variable
    {
		/** @var Variable $variable */
		$variable = $this->getRepository()->findOneBy([
			'name' => $name
		]);

		if ($variable === null) {
			throw new VariableNotFoundException('Variable with name ' . $name . ' not found.');
		}

		return $variable;
	}
}