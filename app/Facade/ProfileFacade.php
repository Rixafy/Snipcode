<?php

namespace App\Facade;

use App\Entity\IpAddress;
use App\Entity\Session;
use App\Repository\CountryRepository;
use App\Repository\IpAddressRepository;
use App\Repository\SessionRepository;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use peterkahl\locale\locale;

class ProfileFacade
{
    /** @var IpAddressRepository @inject */
    public $ipAddressRepository;

    /** @var SessionRepository @inject */
    public $sessionRepository;

    /** @var CountryRepository @inject */
    public $countryRepository;

    /** @var \Nette\Http\Session @inject */
    public $netteSession;

    /** @var IpAddress */
    public $ipAddress;

    /** @var Session */
    public $session;

    /**
     * Called every time before page render
     */
    public function beforeLoad()
    {
        $section = $this->netteSession->getSection('profile');

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

                $this->ipAddressRepository->save($this->ipAddress);
            }

            $section->{'address'} = $this->ipAddress->getId()->toString();
        } else {
            $this->ipAddress = $this->ipAddressRepository->get($section->{'address'});
        }

        if (!isset($section->{'session'})) {
            $this->session = $this->sessionRepository->getByHash($this->netteSession->getId());

            if ($this->session === null || $this->session->getIpAddress()->getId()->getBytes() !== $this->ipAddress->getId()->getBytes()) {
                if ($this->session === null) {
                    $this->session = $this->sessionRepository->create($this->netteSession->getId(), $this->ipAddress);
                } else {
                    $this->session->changeIpAddress($this->ipAddress);
                }

                $this->sessionRepository->save($this->session);
            }

            $section->{'session'} = $this->session->getId()->toString();
        } else {
            $this->session = $this->sessionRepository->get($section->{'session'});
        }

        $this->sessionRepository->flush();
    }

    public function getCurrentIpAddress(): IpAddress
    {
        return $this->ipAddress;
    }
}