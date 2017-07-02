<?php
namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Provider\Client;
use League\OAuth2\Client\Provider\Twsc;
use League\OAuth2\Client\Provider\ValueObjects\Customer;
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

    public function testGetInvoices()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/invoices';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getInvoices($accessToken);
    }

    public function testGetInvoice()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/invoices/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getInvoice($accessToken, 20);
    }

    public function testGetCodes()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/codes';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getCodes($accessToken);
    }

    public function testGetCode()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/codes/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getCode($accessToken, 20);
    }

    public function testGetRepairs()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/repairs';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getRepairs($accessToken);
    }

    public function testGetRepair()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/repairs/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getRepair($accessToken, 20);
    }

    public function testCreateRepair()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/repairs/';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_POST), $this->equalTo($url));
        $client = new Client($twsc);
        $client->createRepair($accessToken, new Repair());
    }

    public function testUpdateRepair()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $repair = new Repair();
        $repair->repair_id = 20;
        $url = '/profile/me/repairs/20';
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
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/objects';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getRepairObjects($accessToken);
    }

    public function testGetRepairObject()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/objects/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getRepairObject($accessToken, 20);
    }

    public function testCreateRepairObject()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/objects/';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_POST), $this->equalTo($url));
        $client = new Client($twsc);
        $client->createRepairObject($accessToken, new RepairObject());
    }

    public function testUpdateRepairObject()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $repairObject = new RepairObject();
        $repairObject->object_id = 20;
        $url = '/profile/me/objects/20';
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
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
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
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
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
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
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

    public function testGetCustomers()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/customers';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getCustomers($accessToken);
    }

    public function testGetCustomer()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/customers/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getCustomer($accessToken, 20);
    }

    public function testUpdateCustomer()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $customer = new Customer();
        $customer->customer_id = 1;
        $url = '/profile/me/customers/1';
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

    public function testGetServceCards()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/service-cards';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getServiceCards($accessToken);
    }

    public function testGetServceCard()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/profile/me/service-cards/20';
        $twsc = $this->getMock(
            Twsc::class,
            ['callApi']
        );
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getServiceCard($accessToken, 20);
    }
}
