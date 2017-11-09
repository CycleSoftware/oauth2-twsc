<?php

namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\ValueObjects\Customer;
use League\OAuth2\Client\Provider\ValueObjects\CustomerPhone;
use League\OAuth2\Client\Provider\ValueObjects\Repair;
use League\OAuth2\Client\Provider\ValueObjects\RepairObject;
use League\OAuth2\Client\Token\AccessToken;

class Client
{
    /**
     * @var Twsc
     */
    public $provider;

    /**
     * Client constructor.
     * @param Twsc $twsc
     */
    public function __construct(Twsc $twsc)
    {
        $this->provider = $twsc;
    }

    public function getInvoices(AccessToken $accessToken, int $customerId, int $offset = 0)
    {
        if ($offset < 0) {
            $offset = 0;
        }
        $relativeUrl = '/customers/' . $customerId . '/invoices?offset=' . $offset;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function getInvoice(AccessToken $accessToken,  int $customerId, int $invoiceId)
    {
        $relativeUrl = '/customers/' . $customerId . '/invoices/' . $invoiceId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function getRepairs(AccessToken $accessToken, int $customerId, int $offset = 0)
    {
        if ($offset < 0) {
            $offset = 0;
        }
        $relativeUrl = '/customers/' . $customerId . '/repairs?offset=' . $offset;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function getRepair(AccessToken $accessToken, int $customerId, int $repairId)
    {
        $relativeUrl = '/customers/' . $customerId . '/repairs/' . $repairId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function createRepair(AccessToken $accessToken, Repair $repair)
    {
        $relativeUrl = '/customers/' . $repair->customer_id . '/repairs/';
        return $this->provider->callApi($accessToken, Twsc::METHOD_POST, $relativeUrl, $repair);
    }

    public function updateRepair(AccessToken $accessToken, Repair $repair)
    {
        $relativeUrl = '/customers/' . $repair->customer_id . '/repairs/' . $repair->customer_order_repair_id;
        return $this->provider->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, $repair);
    }

    public function getRepairObjects(AccessToken $accessToken, int $customerId)
    {
        $relativeUrl = '/customers/' . $customerId . '/objects';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function getRepairObjectsForProfile(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/objects';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function getRepairObject(AccessToken $accessToken, int $customerId, int $objectId)
    {
        $relativeUrl = '/customers/' . $customerId . '/objects/' . $objectId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function createRepairObject(
        AccessToken $accessToken,
        RepairObject $repairObject
    )
    {
        $relativeUrl = '/customers/' . $repairObject->customer_id . '/objects';
        return $this->provider->callApi($accessToken, Twsc::METHOD_POST, $relativeUrl, $repairObject);
    }

    public function updateRepairObject(
        AccessToken $accessToken,
        RepairObject $repairObject
    )
    {
        $relativeUrl = '/customers/' . $repairObject->customer_id . '/objects/' . $repairObject->object_id;
        return $this->provider->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, $repairObject);
    }

    public function getWorkshopTimes(AccessToken $accessToken)
    {
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, '/workshop/times');
    }

    public function getRepairCodes(AccessToken $accessToken)
    {
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, '/workshop/repair-codes');
    }

    public function getProfile(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function getProfileDetails(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/details';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function deleteProfile(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_DELETE, $relativeUrl);
    }

    public function getProfileCustomers(AccessToken $accessToken, string $twscProfileId = 'me')
    {
        $relativeUrl = '/profile/' . $twscProfileId . '/customers';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function getCustomer(AccessToken $accessToken, int $customerId)
    {
        $relativeUrl = '/customers/' . $customerId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function createCustomerPhone(
        AccessToken $accessToken,
        CustomerPhone $customerPhone
    )
    {
        $relativeUrl = '/customers/' . $customerPhone->customer_id . '/phone-numbers';
        return $this->provider->callApi($accessToken, Twsc::METHOD_POST, $relativeUrl, $customerPhone);
    }

    public function updateCustomerPhone(
        AccessToken $accessToken,
        CustomerPhone $customerPhone
    )
    {
        $relativeUrl = '/customers/' . $customerPhone->customer_id . '/phone-numbers/' . $customerPhone->phone_number_id;
        return $this->provider->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, $customerPhone);
    }

    public function updateCustomer(AccessToken $accessToken, Customer $customer)
    {
        $relativeUrl = '/customers/' . $customer->customer_id;
        return $this->provider->callApi($accessToken, Twsc::METHOD_PUT, $relativeUrl, $customer);
    }
    public function getServiceCards(AccessToken $accessToken, int $customerId)
    {
        $relativeUrl = '/customers/' . $customerId . '/service-cards';
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }

    public function getServiceCard(AccessToken $accessToken, int $customerId, int $serviceCardId)
    {
        $relativeUrl = '/customers/' . $customerId . '/service-cards/' . $serviceCardId;
        return $this->provider->callApi($accessToken, Twsc::METHOD_GET, $relativeUrl);
    }
}
