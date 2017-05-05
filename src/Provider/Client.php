<?php
namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ValueObjects\Repair;
use League\OAuth2\Client\Provider\ValueObjects\RepairObject;
use League\OAuth2\Client\Token\AccessToken;

class Client
{
    /**
     * @var Twsc
     */
    public $client;

    /**
     * Client constructor.
     * @param Twsc $twsc
     */
    public  function __construct(Twsc $twsc)
    {
        $this->provider = $twsc;
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getInvoices(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/invoices';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @param string $invoiceId
     * @return mixed
     */
    public function getInvoice(AccessToken $accessToken, string $invoiceId, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/invoices/' . $invoiceId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getCodes(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/codes';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @param string $codeId
     * @return mixed
     */
    public function getCode(AccessToken $accessToken, string $code, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/codes/' . $code;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getRepairs(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/repairs';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @param string $repairId
     * @return mixed
     */
    public function getRepair(AccessToken $accessToken, string $repairId, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/repairs/' . $repairId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @param Repair $repair
     * @return mixed
     */
    public function createRepair(AccessToken $accessToken, Repair $repair, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/repairs/';
        return $this->provider->callApi($accessToken, Twsc::METHOD_POST, $relativeUrl, $repair);
    }

    /**
     * @param AccessToken $accessToken
     * @param Repair $repair
     * @return mixed
     */
    public function updateRepair(AccessToken $accessToken, Repair $repair, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/repairs/' . $repair->repair_id;
        return $this->provider->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, $repair);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getRepairObjects(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/objects';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function getRepairObject(AccessToken $accessToken, string $objectId, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/objects/' . $objectId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @param RepairObject $repairObject
     * @return mixed
     */
    public function createRepairObject(AccessToken $accessToken, RepairObject $repairObject, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/objects/';
        return $this->provider->callApi($accessToken, Twsc::METHOD_POST, $relativeUrl, $repairObject);
    }

    /**
     * @param AccessToken $accessToken
     * @param RepairObject $repairObject
     * @return mixed
     */
    public function updateRepairObject(AccessToken $accessToken, RepairObject $repairObject, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/objects/' . $repairObject->object_id;
        return $this->provider->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, $repairObject);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getWorkshopTimes(AccessToken $accessToken)
    {
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, '/workshop/times');
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getRepairCodes(AccessToken $accessToken)
    {
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, '/workshop/repair-codes');
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getProfile(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getCustomers(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/customers';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @param string $customerId
     * @return mixed
     */
    public function getCustomer(AccessToken $accessToken, string $customerId, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/customers/' . $customerId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getServiceCards(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/service-cards';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @param string $serviceCardId
     * @return mixed
     */
    public function getServiceCard(AccessToken $accessToken, string $serviceCardId, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/service-cards/' . $serviceCardId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }
}