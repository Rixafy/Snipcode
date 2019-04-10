<?php

declare(strict_types=1);

namespace App\Model\Snippet;

use App\Entity\IpAddress;
use App\Entity\Session;
use App\Entity\Syntax;
use App\Repository\BaseRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\UuidInterface;

class SnippetRepository
{
	/** @var EntityManagerInterface */
	private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getRepository()
	{
		return $this->entityManager->getRepository(Snippet::class);
	}

	/**
	 * @throws SnippetNotFoundException
	 */
	public function get(UuidInterface $id): Snippet
    {
    	/** @var Snippet $snippet */
    	$snippet = $this->getRepository()->find($id);

    	if ($snippet === null) {
    		throw new SnippetNotFoundException('Snippet with id ' . $id . ' not found.');
		}

        return $snippet;
    }

	/**
	 * @throws SnippetNotFoundException
	 */
	public function getByAutoIncrement(int $value): Snippet
    {
    	/** @var Snippet $snippet */
        $snippet = $this->getRepository()->findOneBy([
            'auto_increment' => $value
        ]);

        if ($snippet === null) {
			throw new SnippetNotFoundException('Snippet with auto_increment ' . $value . ' not found.');
		}

        return $snippet;
    }

	/**
	 * @throws SnippetNotFoundException
	 */
	public function getBySlug(string $slug): Snippet
    {
    	/** @var Snippet $snippet */
        $snippet = $this->getRepository()->findOneBy(['slug' => $slug]);

		if ($snippet === null) {
			throw new SnippetNotFoundException('Snippet with slug ' . $slug . ' not found.');
		}

		return $snippet;
    }

	/**
	 * @throws SnippetNotFoundException
	 */
	public function getLastBySession(Session $session): Snippet
    {
    	/** @var Snippet $snippet */
        $snippet =  $this->getRepository()->findOneBy([
            'author_session' => $session
        ], [
            'created_at' => 'desc'
        ]);

		if ($snippet === null) {
			throw new SnippetNotFoundException('Snippet with session ' . $session->getId() . ' not found.');
		}

		return $snippet;
    }
}