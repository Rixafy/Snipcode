<?php

declare(strict_types=1);

namespace Snipcode\Model\Syntax;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class SyntaxFacade
{
	/** @var EntityManagerInterface */
	protected $entityManager;

	/** @var SyntaxRepository */
	protected $syntaxRepository;

	/** @var SyntaxFactory */
	protected $syntaxFactory;

	public function __construct(
		EntityManagerInterface $entityManager,
		SyntaxRepository $syntaxRepository,
		SyntaxFactory $syntaxFactory
	) {
		$this->entityManager = $entityManager;
		$this->syntaxRepository = $syntaxRepository;
		$this->syntaxFactory = $syntaxFactory;
	}


	public function create(SyntaxData $syntaxData): Syntax
	{
		$syntax =  $this->syntaxFactory->create($syntaxData);

		$this->entityManager->persist($syntax);
		$this->entityManager->flush();

		return $syntax;
	}

	/**
	 * @throws Exception\SyntaxNotFoundException
	 */
	public function get(UuidInterface $id): Syntax
	{
		return $this->syntaxRepository->get($id);
	}
}