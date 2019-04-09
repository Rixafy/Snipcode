<?php declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;
use Ramsey\Uuid\Uuid;

abstract class BaseRepository
{
    /** @var EntityManagerInterface */
    public $entityManager;

    /** @var EntityRepository */
    public $repository;

    /** @var string */
    protected $class;

    public function __construct(EntityManagerInterface $entityManager, string $class)
    {
        $this->entityManager = $entityManager;
        $this->class = $class;
        $this->repository = $entityManager->getRepository($class);
    }

    /**
     * @param $id
     * @return object
     */
    public function get(string $id)
    {
        return $this->entityManager->find($this->class, Uuid::fromString($id));
    }

    /**
     * @param $id
     * @return object
     */
    public function getReference(string $id)
    {
        $entity = null;

        try {
            $entity = $this->entityManager->getReference($this->class, Uuid::fromString($id));
        } catch (ORMException $e) {
        }

        return $entity;
    }

    public function save($entity, bool $flush = false)
    {
        try {
            $this->entityManager->persist($entity);
        } catch (ORMException $e) {
            exit($e->getMessage());
        }

        if ($flush) {
            try {
                $this->entityManager->flush();
            } catch (\Exception $e) {
                exit($e->getMessage());
            }
        }
    }

    public function remove($entity, $flush = false)
    {
        try {
            $this->entityManager->remove($entity);
        } catch (ORMException $e) {
        }

        if ($flush) {
            try {
                $this->entityManager->flush();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function flush()
    {
        try {
            $this->entityManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function isEmpty(): bool
    {
        return empty($this->entityManager->createQueryBuilder()
            ->select('e.id')
            ->from($this->class, 'e')
            ->setMaxResults(1)
            ->getQuery()
            ->getArrayResult()
        );
    }

    public function getAssociatedArray(string $column, string $nullValue = null, $excluded = null): array
    {
        $result = [];

        if ($nullValue) {
            $result = ['null' => $nullValue];
        }

        $builder = $this->getManager()
            ->createQueryBuilder();

        if ($excluded) {
            if (is_numeric($excluded))
                $excluded = [$excluded];
            $builder->where($builder->expr()->notIn('e.id', $excluded));
        }

        $builder
            ->select('e.id, e.' . $column . '')
            ->resetDQLPart('from')
            ->from($this->class, 'e', 'e.id');

        foreach ($builder->getQuery()->getArrayResult() as $id => $value) {
            $result[$value['id']->{'toString'}()] = $value[$column];
        }

        return $result;
    }

    /**
     * @return EntityManager
     */
    public function getManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @return EntityRepository
     */
    public function getRepository(): EntityRepository
    {
        return $this->repository;
    }
}