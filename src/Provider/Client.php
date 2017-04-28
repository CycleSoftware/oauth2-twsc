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
        $this->client = $twsc;
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getInvoices(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/invoices');
    }

    /**
     * @param AccessToken $accessToken
     * @param string $invoiceId
     * @return mixed
     */
    public function getInvoice(AccessToken $accessToken, string $invoiceId)
    {
        $relativeUrl = '/profile/me/invoices/' . $invoiceId;
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getCodes(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/codes');
    }

    /**
     * @param AccessToken $accessToken
     * @param string $codeId
     * @return mixed
     */
    public function getCode(AccessToken $accessToken, string $codeId)
    {
        $relativeUrl = '/profile/me/codes/' . $codeId;
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getRepairs(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/repairs');
    }

    /**
     * @param AccessToken $accessToken
     * @param string $repairId
     * @return mixed
     */
    public function getRepair(AccessToken $accessToken, string $repairId)
    {
        $relativeUrl = '/profile/me/repairs/' . $repairId;
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @param Repair $repair
     * @return mixed
     */
    public function createRepair(AccessToken $accessToken, Repair $repair)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_POST, '/profile/me/repairs/', $repair);
    }

    /**
     * @param AccessToken $accessToken
     * @param Repair $repair
     * @return mixed
     */
    public function updateRepair(AccessToken $accessToken, Repair $repair)
    {
        $relativeUrl = '/profile/me/repairs/' . $repair->repairId;
        return $this->client->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, $repair);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getObjects(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/objects');
    }

    public function getObject(AccessToken $accessToken, string $objectId)
    {
        $relativeUrl = '/profile/me/objects/' . $objectId;
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    /**
     * @param AccessToken $accessToken
     * @param RepairObject $repairObject
     * @return mixed
     */
    public function createObject(AccessToken $accessToken, RepairObject $repairObject)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_POST, '/profile/me/objects', $repairObject);
    }

    /**
     * @param AccessToken $accessToken
     * @param RepairObject $repairObject
     * @return mixed
     */
    public function updateObject(AccessToken $accessToken, RepairObject $repairObject)
    {
        $relativeUrl = '/profile/me/objects/' . $repairObject->objectId;
        return $this->client->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, $repairObject);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getTimes(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/workshop/times');
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getRepairCodes(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/workshop/repair-codes');
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getProfile(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me');
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getCustomers(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/customers');
    }

    /**
     * @param AccessToken $accessToken
     * @param string $customerId
     * @return mixed
     */
    public function getCustomer(AccessToken $accessToken, string $customerId)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/customers/' . $customerId);
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getServiceCards(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/service-cards');
    }

    /**
     * @param AccessToken $accessToken
     * @param string $serviceCardId
     * @return mixed
     */
    public function getServiceCard(AccessToken $accessToken, string $serviceCardId)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/service-cards/' . $serviceCardId);
    }
}