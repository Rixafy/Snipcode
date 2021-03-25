<?php

declare(strict_types=1);

namespace App\Model\Snippet;

use App\Model\Snippet\Exception\SnippetNotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ObjectRepository;
use Ramsey\Uuid\UuidInterface;

abstract class SnippetRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    private function getRepository(): ObjectRepository
    {
        return $this->entityManager->getRepository(Snippet::class);
    }

    /**
     * @throws SnippetNotFoundException
     */
    public function get(UuidInterface $id): Snippet
    {
        /** @var Snippet $snippet */
        $snippet = $this->getRepository()->findOneBy([
            'id' => $id
        ]);

        if ($snippet === null) {
            throw new SnippetNotFoundException();
        }

        return $snippet;
    }

    /**
     * @throws SnippetNotFoundException
     */
    public function getBySlug(string $slug): Snippet
    {
        /** @var Snippet $snippet */
        $snippet = $this->getRepository()->findOneBy([
            'slug' => $slug
        ]);

        if ($snippet === null) {
            throw new SnippetNotFoundException();
        }

        return $snippet;
    }

    /**
     * @return Snippet[]
     */
    public function getAllBySession(UuidInterface $sessionId): array
    {
        return $this->getRepository()->findBy([
            'session' => $sessionId
        ]);
    }

    /**
     * @return Snippet[]
     */
    public function getAll(): array
    {
        return $this->getQueryBuilderForAll()->getQuery()->execute();
    }

    private function getQueryBuilderForAll(): QueryBuilder
    {
        return $this->getRepository()->createQueryBuilder('e');
    }

    public function getQueryBuilderForDataGrid(): QueryBuilder
    {
        return $this->getQueryBuilderForAll();
    }
}
