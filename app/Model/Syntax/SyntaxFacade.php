<?php

declare(strict_types=1);

namespace App\Model\Syntax;

use App\Model\Syntax\Exception\SyntaxNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

final class SyntaxFacade extends SyntaxRepository
{
	public function __construct(
		private SyntaxFactory $syntaxFactory,
		private EntityManagerInterface $entityManager,
	) {
		parent::__construct($entityManager);
	}

	public function create(SyntaxData $data): Syntax
	{
		$syntax = $this->syntaxFactory->create($data);

		$this->entityManager->persist($syntax);
		$this->entityManager->flush();

		return $syntax;
	}

	/**
	 * @throws SyntaxNotFoundException
	 */
	public function delete(UuidInterface $id): void
	{
		$syntax = $this->get($id);

		$this->entityManager->remove($syntax);
		$this->entityManager->flush();
	}
}
