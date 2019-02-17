<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Country;
use Nettrine\ORM\EntityManager;

class CountryRepository extends BaseRepository
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, Country::class);
    }

    /**
     * @param $id
     * @return Country|object
     */
    public function get(string $id)
    {
        return parent::get($id);
    }

    /**
     * @param string $codeAlpha2
     * @return Country|object
     */
    public function getByCode(string $codeAlpha2)
    {
        return $this->getRepository()->findOneBy(['code_alpha2' => $codeAlpha2]);
    }

    /**
     * @return Country[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param string $name
     * @param string $code_currency
     * @param string $code_continent
     * @param string $code_alpha2
     * @param string $code_language
     * @return Country
     */
    public function create(string $name, string $code_currency, string $code_continent, string $code_alpha2, string $code_language): Country
    {
        return new Country($name, $code_currency, $code_continent, $code_alpha2, $code_language);
    }
}