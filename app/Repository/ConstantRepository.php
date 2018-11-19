<?php

namespace App\Repository;

use App\Entity\Constant;
use Nettrine\ORM\EntityManager;

class ConstantRepository extends BaseRepository
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Constant::class);
    }

    /**
     * @param $id
     * @return Constant|object
     */
    public function get(int $id)
    {
        return parent::get($id);
    }

    /**
     * @param string $name
     * @return Constant|object
     */
    public function getByName(string $name)
    {
        return $this->getRepository()->findOneBy(['name' => $name]);
    }

    /**
     * @return Constant[]
     */
    public function getAll() {
        return $this->getRepository()->findAll();
    }

    /**
     * @param string $name
     * @param string $value
     * @return Constant
     */
    public function create(string $name, string $value): Constant
    {
        return new Constant($name, $value);
    }
}