<?php
namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\TwscProviderException;
use League\OAuth2\Client\Token\AccessToken;

class Client extends Twsc
{
    const METHOD_PUT = 'PUT';

    const INVOICES = 'invoices';
    const INVOICE = 'invoice';
    const CODES = 'codes';
    const CODE = 'code';
    const REPAIRS = 'repairs';
    const REPAIR = 'repair';
    const OBJECTS = 'objects';
    const OBJECT = 'object';
    const TIMES = 'times';
    const REPAIR_CODES = 'repair-codes';
    const PROFILE = 'profile';
    const CUSTOMERS = 'customers';
    const CUSTOMER = 'customer';
    const SERVICE_CARDS = 'service-cards';
    const SERVICE_CARD = 'service-card';

    public $requestedResource;

    public function __construct(array $options = [], array $collaborators = [])
    {
        parent::__construct($options, $collaborators);
    }

    protected function getResourceUrl(string $method, string $id = '')
    {
        if($method === self::METHOD_GET) {
            switch ($this->requestedResource) {
                case self::INVOICES:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/invoices';
                    break;
                case self::INVOICE:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/invoices/2003';
                    break;
                case self::CODES:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/codes';
                    break;
                case self::CODE:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/codes/100';
                    break;
                case self::REPAIRS:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/repairs';
                    break;
                case self::REPAIR:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/repairs/16999487';
                    break;
                case self::OBJECTS:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/objects';
                    break;
                case self::OBJECT:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/objects/2222';
                    break;
                case self::TIMES:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/workshop/times';
                    break;
                case self::REPAIR_CODES:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/workshop/repair-codes';
                    break;
                case self::PROFILE:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me';
                    break;
                case self::CUSTOMERS:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/customers';
                    break;
                case self::CUSTOMER:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/customers/20';
                    break;
                case self::SERVICE_CARDS:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/service-cards';
                    break;
                case self::SERVICE_CARD:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/service-cards/259';
                    break;
                default:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me';
                    break;
            }
        }
        if($method === self::METHOD_POST) {
            switch($this->requestedResource) {
                case self::REPAIRS:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/repairs/';
                    break;
                case self::OBJECTS:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/objects';
                    break;
                default:
                    throw new TwscProviderException(_("Resource does not support method POST."));
            }
        }
        if($method === self::METHOD_PUT) {
            switch($this->requestedResource) {
                case self::REPAIRS:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/repairs/' . $id;
                    break;
                case self::OBJECTS:
                    return $this->base_twsc_api_url . '/' . $this->api_version . '/profile/me/objects/' . $id;
                    break;
                default:
                    throw new TwscProviderException(_("Resource does not support method PUT."));
            }
        }
        throw new TwscProviderException(_("Twsc provider: Unsupported HTTP method"));
    }

    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->getResourceUrl(self::METHOD_GET);
    }

    public function postResource(AccessToken $token, array $body = []) : array
    {
        $options['body'] = json_encode($body);
        $uri = $this->getResourceUrl(self::METHOD_POST);
        $request = $this->createRequest(self::METHOD_POST, $uri, $token, $options);
        $response = $this->getResponse($request);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function putResource(AccessToken $token, string $id, array $body = [])
    {
        $options['body'] = json_encode($body);
        $uri = $this->getResourceUrl(self::METHOD_PUT, $id);
        $request = $this->createRequest(self::METHOD_PUT, $uri, $token, $options);
        $response = $this->getResponse($request);
        return json_decode($response->getBody()->getContents());
    }

    public function createResourceOwner(array $response, AccessToken $token)
    {
        return new TwscResourceOwner($response);
    }
}