<?php

namespace App\Repository;

use App\Entity\Session;
use Nettrine\ORM\EntityManager;

class SessionRepository extends BaseRepository
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Session::class);
    }

    /**
     * @param $id
     * @return Session|object
     */
    public function get(int $id)
    {
        return parent::get($id);
    }

    /**
     * @param string $name
     * @return Session|object
     */
    public function getByName(string $name)
    {
        return $this->getRepository()->findOneBy(['name' => $name]);
    }

    /**
     * @return Session[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param string $name
     * @param string $value
     * @return Session
     */
    public function create(string $name, string $value): Session
    {
        return new Session($name, $value);
    }
}