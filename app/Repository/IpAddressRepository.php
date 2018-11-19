<?php

namespace App\Repository;

use App\Entity\Country;
use App\Entity\IpAddress;
use Nettrine\ORM\EntityManager;

class IpAddressRepository extends BaseRepository
{
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, IpAddress::class);
    }

    /**
     * @param $id
     * @return IpAddress|object
     */
    public function get(int $id)
    {
        return parent::get($id);
    }

    /**
     * @param string $address
     * @return IpAddress|object
     */
    public function getByAddress(string $address)
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

    /**
     * @param string $address
     * @param string $domain_host
     * @param bool $ipv6
     * @param Country $country
     * @return IpAddress
     */
    public function create(string $address, string $domain_host, bool $ipv6, Country $country): IpAddress
    {
        return new IpAddress($address, $domain_host, $ipv6, $country);
    }
}