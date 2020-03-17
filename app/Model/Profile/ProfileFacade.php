<?php declare(strict_types=1);

namespace Snipcode\Facade;

use Exception;
use Rixafy\Country\Exception\CountryNotFoundException;
use Snipcode\Entity\IpAddress;
use Snipcode\Entity\Session;
use Snipcode\Repository\CountryRepository;
use Snipcode\Repository\IpAddressRepository;
use Snipcode\Repository\SessionRepository;
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

				if (isset($_SERVER['HTTP_CF_IPCOUNTRY']) && !empty($_SERVER['HTTP_CF_IPCOUNTRY'])) {
					$country = $this->countryRepository->getByCode($_SERVER['HTTP_CF_IPCOUNTRY']);
				} else {
					throw new Exception('Header "HTTP_CF_IPCOUNTRY" not found in http request.');
				}
				
				if ($country === null) {
					$country = $this->countryRepository->getByCode('US');
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

    /**
     * @return IpAddress
     */
    public function getCurrentIpAddress(): IpAddress
    {
        return $this->ipAddress;
    }

    /**
     * @return Session
     */
    public function getCurrentSession(): Session
    {
        return $this->session;
    }
}