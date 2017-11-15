<?php
namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Provider\Client;
use League\OAuth2\Client\Provider\Twsc;
use League\OAuth2\Client\Provider\ValueObjects\Customer;
use League\OAuth2\Client\Provider\ValueObjects\CustomerPhone;
use League\OAuth2\Client\Provider\ValueObjects\Repair;
use League\OAuth2\Client\Provider\ValueObjects\RepairObject;
use Mockery as m;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    protected $apiVersion = 'v1';

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }

    public function testCreateRating()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/workshop/rate/1';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_POST), $this->equalTo($url), []);
        $client = new Client($twsc);
        $client->createRating($accessToken, 1, []);
    }

    public function testGetInvoices()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/invoices?offset=12';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getInvoices($accessToken, 1000, 12);
    }

    public function testGetInvoice()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/invoices/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getInvoice($accessToken, 1000, 20);
    }

    public function testGetRepairs()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/repairs?offset=12';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getRepairs($accessToken, 1000, 12);
    }

    public function testGetRepair()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/repairs/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getRepair($accessToken, 1000, 20);
    }

    public function testCreateRepair()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/repairs';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_POST), $this->equalTo($url));
        $client = new Client($twsc);
        $repair = new Repair();
        $repair->customer_id = 1000;
        $client->createRepair($accessToken, $repair);
    }

    public function testUpdateRepair()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);

        $repair = new Repair();
        $repair->customer_id = 1000;
        $repair->customer_order_repair_id = 3322;
        $url = '/customers/1000/repairs/3322';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_PUT), $this->equalTo($url));
        $client = new Client($twsc);
        $client->updateRepair($accessToken, $repair);
    }

    public function testGetRepairObjects()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/objects';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getRepairObjects($accessToken, 1000);
    }

    public function testGetRepairObject()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/objects/2000';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getRepairObject($accessToken, 1000, 2000);
    }

    public function testCreateRepairObject()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/objects';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_POST), $this->equalTo($url));
        $client = new Client($twsc);
        $repair = new RepairObject();
        $repair->customer_id = 1000;
        $client->createRepairObject($accessToken, $repair);
    }

    public function testUpdateRepairObject()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $repairObject = new RepairObject();
        $repairObject->customer_id = 1000;
        $repairObject->object_id = 20;
        $url = '/customers/1000/objects/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_PUT), $this->equalTo($url), $this->equalTo($repairObject));
        $client = new Client($twsc);
        $client->updateRepairObject($accessToken, $repairObject);
    }

    public function testGetWorkshopTimes()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/workshop/times';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getWorkshopTimes($accessToken);
    }

    public function testGetRepairCodes()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/workshop/repair-codes';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getRepairCodes($accessToken);
    }

    public function testGetProfile()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/profile/me';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getProfile($accessToken);
    }

    public function testGetFullProfile()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/profile/me/details';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getProfileDetails($accessToken);
    }

    public function testDeleteProfile()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/profile/me';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_DELETE), $this->equalTo($url));
        $client = new Client($twsc);
        $client->deleteProfile($accessToken);
    }

    public function testGetCustomers()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/profile/me/customers';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getProfileCustomers($accessToken);
    }

    public function testGetCustomer()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getCustomer($accessToken, 1000);
    }

    public function testCreateCustomerPhone()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/phone-numbers';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_POST), $this->equalTo($url));
        $client = new Client($twsc);
        $customerPhone = new CustomerPhone();
        $customerPhone->customer_id = 1000;
        $client->createCustomerPhone($accessToken, $customerPhone);
    }

    public function testUpdateCustomerPhone()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/phone-numbers/1';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_PUT), $this->equalTo($url));
        $client = new Client($twsc);
        $customerPhone = new CustomerPhone();
        $customerPhone->customer_id = 1000;
        $customerPhone->phone_number_id = 1;
        $client->updateCustomerPhone($accessToken, $customerPhone);
    }

    public function testUpdateCustomer()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $customer = new Customer();
        $customer->customer_id = 1000;
        $url = '/customers/1000';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_PUT), $this->equalTo($url), $this->equalTo($customer));
        $client = new Client($twsc);
        $client->updateCustomer($accessToken, $customer);
    }

    public function testGetServiceCards()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/service-cards';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getServiceCards($accessToken, 1000);
    }

    public function testGetServiceCard()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/service-cards/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getServiceCard($accessToken, 1000, 20);
    }
}
