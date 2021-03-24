<?php

declare(strict_types=1);

namespace App\Model\Syntax;

use App\Model\Syntax\Exception\SyntaxNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\UuidInterface;

abstract class SyntaxRepository
{
	public function __construct(
	    private EntityManagerInterface $entityManager
    ) {}

	private function getRepository(): ObjectRepository
	{
		return $this->entityManager->getRepository(Syntax::class);
	}

	/**
	 * @throws SyntaxNotFoundException
	 */
	public function get(UuidInterface $id): Syntax
	{
		/** @var Syntax $syntax */
		$syntax = $this->getRepository()->findOneBy([
			'id' => $id
		]);

		if ($syntax === null) {
			throw new SyntaxNotFoundException();
		}

		return $syntax;
	}

	/**
	 * @throws SyntaxNotFoundException
	 */
	public function getByName(string $name): Syntax
	{
		/** @var Syntax $syntax */
		$syntax = $this->getRepository()->findOneBy([
			'name' => $name
		]);

		if ($syntax === null) {
			throw new SyntaxNotFoundException();
		}

		return $syntax;
	}

	/**
	 * @return Syntax[]
	 */
	public function getAll(): array
	{
		return $this->getQueryBuilderForAll()->getQuery()->execute();
	}

	private function getQueryBuilderForAll(): QueryBuilder
	{
		return $this->getRepository()
            ->createQueryBuilder('e')
            ->orderBy('e.name', 'ASC');
	}

	public function getQueryBuilderForDataGrid(): QueryBuilder
	{
		return $this->getQueryBuilderForAll();
	}

    public function mapForFormData(): array
    {
        $syntaxList = [];

        foreach ($this->getAll() as $syntax) {
            $syntaxList[(string) $syntax->getId()] = $syntax->getName();
        }

        return $syntaxList;
    }
}
