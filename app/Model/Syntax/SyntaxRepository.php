<?php

declare(strict_types=1);

namespace Snipcode\Model\Syntax;

use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;
use Snipcode\Model\Syntax\Exception\SyntaxNotFoundException;

class SyntaxRepository
{
	/** @var EntityManagerInterface */
	protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getRepository()
	{
		return $this->entityManager->getRepository(Syntax::class);
	}

	/**
	 * @throws SyntaxNotFoundException
	 */
	public function get(UuidInterface $id)
    {
    	$syntax = $this->getRepository()->find($id);

    	if ($syntax === null) {
    		throw new SyntaxNotFoundException('Syntax with id ' . $id . ' not found.');
		}

    	return $syntax;
    }
}
