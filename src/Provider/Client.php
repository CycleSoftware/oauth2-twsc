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
     * @param string $invoice_id
     * @return mixed
     */
    public function getInvoice(AccessToken $accessToken, string $invoice_id)
    {
        $relative_url = '/profile/me/invoices/' . $invoice_id;
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, $relative_url);
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
     * @param string $code_id
     * @return mixed
     */
    public function getCode(AccessToken $accessToken, string $code_id)
    {
        $relative_url = '/profile/me/codes/' . $code_id;
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, $relative_url);
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
     * @param string $repair_id
     * @return mixed
     */
    public function getRepair(AccessToken $accessToken, string $repair_id)
    {
        $relative_url = '/profile/me/repairs/' . $repair_id;
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, $relative_url);
    }

    /**
     * @param AccessToken $accessToken
     * @param Repair $repair
     * @return mixed
     */
    public function createRepair(AccessToken $accessToken, Repair $repair)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_POST, '/profile/me/repairs/', json_encode($repair));
    }

    /**
     * @param AccessToken $accessToken
     * @param Repair $repair
     * @return mixed
     */
    public function updateRepair(AccessToken $accessToken, Repair $repair)
    {
        $relativeUrl = '/profile/me/repairs/' . $repair->repair_id;
        return $this->client->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, json_encode($repair));
    }

    /**
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function getObjects(AccessToken $accessToken)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/objects');
    }

    public function getObject(AccessToken $accessToken, string $object_id)
    {
        $relative_url = '/profile/me/objects/' . $object_id;
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, $relative_url);
    }

    /**
     * @param AccessToken $accessToken
     * @param RepairObject $repairObject
     * @return mixed
     */
    public function createObject(AccessToken $accessToken, RepairObject $repairObject)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_POST, '/profile/me/objects', json_encode($repairObject));
    }

    /**
     * @param AccessToken $accessToken
     * @param RepairObject $repairObject
     * @return mixed
     */
    public function updateObject(AccessToken $accessToken, RepairObject $repairObject)
    {
        $relativeUrl = '/profile/me/objects/' . $repairObject->object_id;
        return $this->client->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, json_encode($repairObject));
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
     * @param string $customer_id
     * @return mixed
     */
    public function getCustomer(AccessToken $accessToken, string $customer_id)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/customer/' . $customer_id);
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
     * @param string $service_card_id
     * @return mixed
     */
    public function getServiceCard(AccessToken $accessToken, string $service_card_id)
    {
        return $this->client->callApi($accessToken, Twsc::METHOD_GET, '/profile/me/service-cards/' . $service_card_id);
    }
}