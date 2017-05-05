<?php
namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Provider\Twsc;
use League\OAuth2\Client\Provider\TwscResourceOwner;
use League\OAuth2\Client\Provider\ValueObjects\Repair;
use Mockery as m;

class TwscTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Twsc
     */
    protected $provider;
    protected $apiVersion = 'v1';

    protected function setUp()
    {
        $this->provider = new \League\OAuth2\Client\Provider\Twsc(
            [
                'clientId'     => 'mock_client_id',
                'clientSecret' => 'mock_secret',
                'redirectUri'  => 'none',
            ]
        );
    }

    public function tearDown()
    {
        m::close();
        parent::tearDown();
    }

    public function testCallApiMethodGet()
    {
        $result = ['email' => 'john.smith@e.mail'];
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');//new AccessToken(['access_token' => 'access_token']);
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $stream = m::mock('Psr\Http\Message\StreamInterface');
        $stream->shouldReceive('getContents')->times(1)->andReturn(json_encode($result));
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->times(1)->andReturn($stream);
        $provider = $this->getMock(
            Twsc::class,
            ['createRequest', 'getResponse']
        );
        $provider->expects($this->once())
            ->method('createRequest')
            ->with($this->equalTo(Twsc::METHOD_GET), $this->equalTo('https://api.twsc.nl/v1/profile/me'), $this->equalTo($accessToken), $this->equalTo([]))
            ->will($this->returnValue($request));
        $provider->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo($request))
            ->will($this->returnValue($response));
        $resultReturned = $provider->callApi($accessToken, Twsc::METHOD_GET, '/profile/me');
        $this->assertEquals($result, $resultReturned);
    }

    public function testCallApiMethodPost()
    {
        $body = new Repair();
        $result = ['email' => 'john.smith@e.mail'];
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');//new AccessToken(['access_token' => 'access_token']);
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $stream = m::mock('Psr\Http\Message\StreamInterface');
        $stream->shouldReceive('getContents')->times(1)->andReturn(json_encode($result));
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->times(1)->andReturn($stream);
        $provider = $this->getMock(
            Twsc::class,
            ['createRequest', 'getResponse']
        );
        $provider->expects($this->once())
            ->method('createRequest')
            ->with(
                $this->equalTo(Twsc::METHOD_POST),
                $this->equalTo('https://api.twsc.nl/v1/profile/me/repairs'),
                $this->equalTo($accessToken),
                $this->equalTo(['body' => json_encode($body)])
            )
            ->will($this->returnValue($request));
        $provider->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo($request))
            ->will($this->returnValue($response));
        $resultReturned = $provider->callApi($accessToken, Twsc::METHOD_POST, '/profile/me/repairs', $body);
        $this->assertEquals($result, $resultReturned);
    }

    public function testAuthorizationUrl()
    {
        $url = $this->provider->getAuthorizationUrl();
        $uri = parse_url($url);
        parse_str($uri['query'], $query);
        $this->assertArrayHasKey('client_id', $query);
        $this->assertArrayHasKey('redirect_uri', $query);
        $this->assertArrayHasKey('state', $query);
        $this->assertArrayHasKey('scope', $query);
        $this->assertArrayHasKey('response_type', $query);
        $this->assertArrayHasKey('approval_prompt', $query);
        $this->assertNotNull($this->provider->getState());
    }

    public function testScopes()
    {
        $options = ['scope' => [uniqid(), uniqid()]];
        $url     = $this->provider->getAuthorizationUrl($options);
        $this->assertContains(urlencode(implode(',', $options['scope'])), $url);
    }

    public function testGetAuthorizationUrl()
    {
        $url = $this->provider->getAuthorizationUrl();
        $uri = parse_url($url);
        $this->assertEquals('/oauth/authorize', $uri['path']);
    }

    public function testGetBaseAccessTokenUrl()
    {
        $params = [];
        $url    = $this->provider->getBaseAccessTokenUrl($params);
        $uri    = parse_url($url);
        $this->assertEquals('/oauth/token', $uri['path']);
    }

    public function testGetAccessToken()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn(
            '{"access_token":"mock_access_token", "scope":"repo,gist", "token_type":"bearer"}'
        );
        $response->shouldReceive('getHeader')->andReturn(['content-type' => 'json']);
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $this->provider->setHttpClient($client);
        $token = $this->provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);
        $this->assertEquals('mock_access_token', $token->getToken());
        $this->assertNull($token->getExpires());
        $this->assertNull($token->getRefreshToken());
        $this->assertNull($token->getResourceOwnerId());
    }

    public function testTwscDomainUrls()
    {
        $provider = new \League\OAuth2\Client\Provider\Twsc([
            'apiVersion' => $this->apiVersion
        ]);

        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->times(1)->andReturn(
            'access_token=mock_access_token&expires=3600&refresh_token=mock_refresh_token&otherKey={1234}'
        );
        $response->shouldReceive('getHeader')->andReturn(['content-type' => 'application/x-www-form-urlencoded']);
        $response->shouldReceive('getStatusCode')->andReturn(200);
        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $provider->setHttpClient($client);
        $token = $provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);
        $this->assertEquals(
            $provider->getBaseTwscOauthUrl() . '/oauth/authorize',
            $provider->getBaseAuthorizationUrl()
        );
        $this->assertEquals(
            $provider->getBaseTwscOauthUrl() . '/oauth/token',
            $provider->getBaseAccessTokenUrl([])
        );
        $this->assertEquals(
            $provider->getBaseTwscApiUrl() . '/v1/profile/me',
            $provider->getResourceOwnerDetailsUrl($token)
        );
        $this->assertEquals(
            $provider->getApiVersion(),
            $this->apiVersion
        );

    }

    public function testUserData()
    {
        $userId    = rand(1000, 9999);
        $firstName = uniqid();
        $lastName  = uniqid();
        $email     = uniqid();
        $premium   = false;

        $postResponse = m::mock('Psr\Http\Message\ResponseInterface');
        $postResponse->shouldReceive('getBody')->andReturn(
            'access_token=mock_access_token&expires=3600&refresh_token=mock_refresh_token&otherKey={1234}'
        );
        $postResponse->shouldReceive('getHeader')->andReturn(['content-type' => 'application/x-www-form-urlencoded']);
        $postResponse->shouldReceive('getStatusCode')->andReturn(200);
        $userResponse = m::mock('Psr\Http\Message\ResponseInterface');
        $userResponse->shouldReceive('getBody')->andReturn(
            '{"id": ' . $userId . ', "firstname": "' . $firstName . '", "lastname": "' . $lastName . '", "email": "' . $email . '", "premium": "' . $premium . '"}'
        );
        $userResponse->shouldReceive('getHeader')->andReturn(['content-type' => 'json']);
        $userResponse->shouldReceive('getStatusCode')->andReturn(200);
        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')
            ->times(2)
            ->andReturn($postResponse, $userResponse);
        $this->provider->setHttpClient($client);
        $token = $this->provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);
        /** @var TwscResourceOwner $user */
        $user  = $this->provider->getResourceOwner($token);
        $this->assertEquals($userId, $user->getId());
        $this->assertEquals($userId, $user->toArray()['id']);
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($firstName, $user->toArray()['firstname']);
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($lastName, $user->toArray()['lastname']);
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($email, $user->toArray()['email']);
    }

    /**
     * @expectedException \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     **/
    public function testExceptionThrownWhenErrorObjectReceived()
    {
        $message      = uniqid();
        $status       = rand(400, 600);

        $postResponse = m::mock('Psr\Http\Message\ResponseInterface');
        $postResponse->shouldReceive('getBody')->andReturn(' {"message":"' . $message . '"}');
        $postResponse->shouldReceive('getHeader')->andReturn(['content-type' => 'json']);
        $postResponse->shouldReceive('getStatusCode')->andReturn($status);

        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')
            ->times(1)
            ->andReturn($postResponse);

        $this->provider->setHttpClient($client);
        $this->provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);
    }
}
