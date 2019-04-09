<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\IpAddress;
use App\Entity\Session;
use Doctrine\ORM\EntityManagerInterface;

class SessionRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
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

    public function getByHash(string $hash): ?Session
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

    public function create(string $hash, IpAddress $ipAddress): Session
    {
        return new Session($hash, $ipAddress);
    }
}