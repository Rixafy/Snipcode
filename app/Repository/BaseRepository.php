<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\TransactionRequiredException;
use Nettrine\ORM\EntityManager;
use Ramsey\Uuid\Uuid;

abstract class BaseRepository
{
    /** @var EntityManager */
    public $entityManager;

    /** @var EntityRepository */
    public $repository;

    /** @var string */
    protected $class;

    public function __construct(EntityManager $entityManager, string $class)
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
        $entity = null;

        bdump($id);

        try {
            $entity = $this->entityManager->find($this->class, Uuid::fromString($id));
        } catch (OptimisticLockException $e) {
        } catch (TransactionRequiredException $e) {
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