<?php

namespace App\Facade;

use App\Entity\IpAddress;
use App\Repository\CountryRepository;
use App\Repository\IpAddressRepository;
use Nette\Application\UI\Presenter;
use Nette\Http\Session;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use peterkahl\locale\locale;

class ProfileFacade
{
    /** @var IpAddressRepository @inject */
    public $ipAddressRepository;

    /** @var CountryRepository @inject */
    public $countryRepository;

    /** @var Session @inject */
    public $session;

    /** @var IpAddress */
    public $ipAddress;

    /**
     * Called every time before page render
     */
    public function beforeLoad()
    {
        $section = $this->session->getSection('profile');

        if (!isset($section->{'address'})) {
            $this->ipAddress = $this->ipAddressRepository->getByAddress($_SERVER['REMOTE_ADDR']);

            if ($this->ipAddress === null) {
                $country = null;

                $ctx = stream_context_create(array('http' => array('timeout' => 3)));
                if ($data = @file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $_SERVER['REMOTE_ADDR'], false, $ctx)) {
                    try {
                        if ($json = Json::decode($data)) {
                            $country = $this->countryRepository->getByCode($json->geoplugin_countryCode);
                            if (!$country) {
                                $country = $this->countryRepository->create($json->geoplugin_countryName, $json->geoplugin_continentCode, $json->geoplugin_currencyCode, locale::country2locale($json->geoplugin_countryCode), $json->geoplugin_countryCode);
                            }
                        }
                     } catch (JsonException $e) {

                    }
                }

                $this->ipAddress = $this->ipAddressRepository->create($_SERVER['REMOTE_ADDR'], $country);

                $this->ipAddressRepository->save($this->ipAddress, true);
            }

            $section->{'address'} = $this->ipAddress->getId();
        } else {
            $this->ipAddress = $this->ipAddressRepository->get($section->{'address'});
        }
    }

    public function getCurrentIpAddress(): IpAddress
    {
        return $this->ipAddress;
    }
}