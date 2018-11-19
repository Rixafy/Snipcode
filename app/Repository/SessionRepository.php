<?php

namespace App\Repository;

use App\Entity\IpAddress;
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
    public function get(string $id)
    {
        return parent::get($id);
    }

    /**
     * @param string $hash
     * @return Session|object
     */
    public function getByHash(string $hash)
    {
        return $this->getRepository()->findOneBy(['hash' => $hash]);
    }

    /**
     * @return Session[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param string $hash
     * @param IpAddress $ipAddress
     * @return Session
     */
    public function create(string $hash, IpAddress $ipAddress): Session
    {
        return new Session($hash, $ipAddress);
    }
}