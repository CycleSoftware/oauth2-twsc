<?php
namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Provider\Client;
use League\OAuth2\Client\Provider\Twsc;
use League\OAuth2\Client\Provider\ValueObjects\Customer;
use League\OAuth2\Client\Provider\ValueObjects\CustomerPhone;
use League\OAuth2\Client\Provider\ValueObjects\Repair;
use League\OAuth2\Client\Provider\ValueObjects\RepairObject;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    protected $apiVersion = 'v1';

    public function tearDown(): void
    {
        m::close();
        parent::tearDown();
    }

    public function testCreateRating()
    {
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $url = '/workshop/rate/1';
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getWorkshopTimes($accessToken);
    }

    public function testGetWorkshopTimesPerStore()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/workshop/times-per-store';
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getWorkshopTimesPerStore($accessToken);
    }

    public function testGetRepairCodes()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/workshop/repair-codes';
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_PUT), $this->equalTo($url), $this->equalTo($customer));
        $client = new Client($twsc);
        $client->updateCustomer($accessToken, $customer);
    }

    public function testCreateCustomer()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $customer = new Customer();
        $url = '/customers';
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_POST), $this->equalTo($url), $this->equalTo($customer));
        $client = new Client($twsc);
        $client->createCustomer($accessToken, $customer);
    }

    public function testFindCustomers()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/find';
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url . '?phone_number=0733030050'))
            ->will($this->returnValue([new Customer()]));
        $client = new Client($twsc);
        $array_of_objects = $client->findCustomers($accessToken, ['phone_number' => '0733030050']);
        $this->assertCount(1, $array_of_objects);
    }

    public function testGetServiceCards()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/1000/service-cards';
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
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
        $twsc = $this->getMockBuilder(
            Twsc::class
        )->onlyMethods(
            ['callApi']
        )->getMock();
        $twsc->expects($this->once())
            ->method('callApi')
            ->with($this->equalTo($accessToken), $this->equalTo(Twsc::METHOD_GET), $this->equalTo($url));
        $client = new Client($twsc);
        $client->getServiceCard($accessToken, 1000, 20);
    }

    /**
     * Builds a Twsc mock that expects exactly one callApi call with the given arguments.
     */
    private function expectCallApi($accessToken, $method, $url, $body = null, $returnValue = null)
    {
        $twsc = $this->getMockBuilder(Twsc::class)->onlyMethods(['callApi'])->getMock();
        $args = [$this->identicalTo($accessToken), $this->equalTo($method), $this->equalTo($url)];
        if (func_num_args() >= 4) {
            $args[] = $this->equalTo($body);
        }
        $twsc->expects($this->once())
            ->method('callApi')
            ->with(...$args)
            ->willReturn($returnValue);
        return $twsc;
    }

    public function testConstructorStoresProvider()
    {
        $twsc = $this->getMockBuilder(Twsc::class)->onlyMethods(['callApi'])->getMock();
        $client = new Client($twsc);
        $this->assertSame($twsc, $client->provider);
    }

    public function testCreateRatingPassesRatingAsBody()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $rating = ['score' => 5, 'comment' => 'Top'];
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_POST, '/workshop/rate/7', $rating, ['ok' => true]);
        $client = new Client($twsc);
        $this->assertSame(['ok' => true], $client->createRating($accessToken, 7, $rating));
    }

    public function testGetInvoicesDefaultOffsetIsZero()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/customers/1000/invoices?offset=0');
        (new Client($twsc))->getInvoices($accessToken, 1000);
    }

    public function testGetInvoicesNegativeOffsetIsClampedToZero()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/customers/1000/invoices?offset=0');
        (new Client($twsc))->getInvoices($accessToken, 1000, -5);
    }

    public function testGetRepairsDefaultOffsetIsZero()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/customers/1000/repairs?offset=0');
        (new Client($twsc))->getRepairs($accessToken, 1000);
    }

    public function testGetRepairsNegativeOffsetIsClampedToZero()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/customers/1000/repairs?offset=0');
        (new Client($twsc))->getRepairs($accessToken, 1000, -1);
    }

    public function testCreateRepairPassesRepairAsBody()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $repair = new Repair();
        $repair->customer_id = 1000;
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_POST, '/customers/1000/repairs', $repair);
        (new Client($twsc))->createRepair($accessToken, $repair);
    }

    public function testGetRepairObjectsForProfileDefaultsToMe()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/profile/me/objects', null, [['object_id' => 1]]);
        $result = (new Client($twsc))->getRepairObjectsForProfile($accessToken);
        $this->assertSame([['object_id' => 1]], $result);
    }

    public function testGetRepairObjectsForProfileWithCustomProfileId()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/profile/abc-123/objects');
        (new Client($twsc))->getRepairObjectsForProfile($accessToken, 'abc-123');
    }

    public function testGetWorkshopTimesWithDayCount()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/workshop/times?day_count=14');
        (new Client($twsc))->getWorkshopTimes($accessToken, 14);
    }

    public function testGetWorkshopTimesCastsDayCountToInt()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/workshop/times?day_count=7');
        (new Client($twsc))->getWorkshopTimes($accessToken, '7abc');
    }

    public function testGetWorkshopTimesPerStoreWithDayCount()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/workshop/times-per-store?day_count=3');
        (new Client($twsc))->getWorkshopTimesPerStore($accessToken, 3);
    }

    public function testGetWorkshopTimesPerStoreWithZeroDayCount()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/workshop/times-per-store?day_count=0');
        (new Client($twsc))->getWorkshopTimesPerStore($accessToken, 0);
    }

    public function testGetWorkshopInfo()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/workshop/info', null, ['name' => 'Shop']);
        $this->assertSame(['name' => 'Shop'], (new Client($twsc))->getWorkshopInfo($accessToken));
    }

    /**
     * @dataProvider customProfileIdProvider
     */
    public function testProfileMethodsWithCustomProfileId($clientMethod, $httpMethod, $expectedUrl)
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $twsc = $this->expectCallApi($accessToken, $httpMethod, $expectedUrl);
        (new Client($twsc))->{$clientMethod}($accessToken, '42');
    }

    public function customProfileIdProvider()
    {
        return [
            'getProfile' => ['getProfile', Twsc::METHOD_GET, '/profile/42'],
            'getProfileDetails' => ['getProfileDetails', Twsc::METHOD_GET, '/profile/42/details'],
            'deleteProfile' => ['deleteProfile', Twsc::METHOD_DELETE, '/profile/42'],
            'getProfileCustomers' => ['getProfileCustomers', Twsc::METHOD_GET, '/profile/42/customers'],
        ];
    }

    public function testCreateCustomerPhonePassesPhoneAsBody()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $phone = new CustomerPhone();
        $phone->customer_id = 1000;
        $phone->phone_number = '0612345678';
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_POST, '/customers/1000/phone-numbers', $phone);
        (new Client($twsc))->createCustomerPhone($accessToken, $phone);
    }

    public function testFindCustomersWithoutParametersThrows()
    {
        $twsc = $this->getMockBuilder(Twsc::class)->onlyMethods(['callApi'])->getMock();
        $twsc->expects($this->never())->method('callApi');
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);

        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessage('No find parameters given');
        (new Client($twsc))->findCustomers($accessToken, []);
    }

    public function testFindCustomersEncodesMultipleParameters()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $url = '/customers/find?postal_code=1234+AB&housenumber=10&email=john%40e.mail';
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, $url);
        (new Client($twsc))->findCustomers($accessToken, [
            'postal_code' => '1234 AB',
            'housenumber' => '10',
            'email' => 'john@e.mail',
        ]);
    }

    public function testGetCustomerReturnsProviderResult()
    {
        $accessToken = m::mock(\League\OAuth2\Client\Token\AccessToken::class);
        $data = ['customer_id' => 1000, 'name' => 'Smith'];
        $twsc = $this->expectCallApi($accessToken, Twsc::METHOD_GET, '/customers/1000', null, $data);
        $this->assertSame($data, (new Client($twsc))->getCustomer($accessToken, 1000));
    }
}
