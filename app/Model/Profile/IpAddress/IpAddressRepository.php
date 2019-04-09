<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Country;
use App\Entity\IpAddress;
use Doctrine\ORM\EntityManagerInterface;

class IpAddressRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct($entityManager, IpAddress::class);
    }

    /**
     * @param $id
     * @return IpAddress|object
     */
    public function get(string $id)
    {
        return parent::get($id);
    }

    public function getByAddress(string $address): ?IpAddress
    {
        return $this->getRepository()->findOneBy(['address' => $address]);
    }

    /**
     * @return IpAddress[]
     */
    public function getAll()
    {
        return $this->getRepository()->findAll();
    }

    public function create(string $address, Country $country): IpAddress
    {
        return new IpAddress($address, gethostbyaddr($address), strlen($address) > 15, $country);
    }
}