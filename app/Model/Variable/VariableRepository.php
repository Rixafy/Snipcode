<?php

namespace App\Repository;

use App\Entity\Variable;
use Nettrine\ORM\EntityManager;

class VariableRepository extends BaseRepository
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Variable::class);
    }

    /**
     * @param $id
     * @return Variable|object
     */
    public function get(string $id)
    {
        return parent::get($id);
    }

    /**
     * @param string $name
     * @return Variable|object
     */
    public function getByName(string $name)
    {
        return $this->getRepository()->findOneBy([
            'name' => $name
        ]);
    }

    /**
     * @param string $name
     * @param int $value
     * @return Variable
     */
    public function create(string $name, int $value): Variable
    {
        return new Variable($name, $value);
    }
}