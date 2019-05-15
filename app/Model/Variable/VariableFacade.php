<?php

declare(strict_types=1);

namespace Snipcode\Model\Variable;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class VariableFacade
{
	/** @var EntityManagerInterface */
	protected $entityManager;

	/** @var VariableRepository */
	protected $variableRepository;

	/** @var VariableFactory */
	protected $variableFactory;

	public function __construct(
		EntityManagerInterface $entityManager,
		VariableRepository $variableRepository,
		VariableFactory $variableFactory
	) {
		$this->entityManager = $entityManager;
		$this->variableRepository = $variableRepository;
		$this->variableFactory = $variableFactory;
	}

	public function create(VariableData $variableData): Variable
	{
		$variable =  $this->variableFactory->create($variableData);

		$this->entityManager->persist($variable);
		$this->entityManager->flush();

		return $variable;
	}

	/**
	 * @throws Exception\VariableNotFoundException
	 */
	public function get(UuidInterface $id): Variable
	{
		return $this->variableRepository->get($id);
	}

	/**
	 * @throws Exception\VariableNotFoundException
	 */
	public function getByName(string $name): Variable
	{
		return $this->variableRepository->getByName($name);
	}
}
