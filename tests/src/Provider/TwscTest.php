<?php

namespace League\OAuth2\Client\Test\Provider;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Utils;
use League\OAuth2\Client\Provider\ClientErrorException;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Provider\Twsc;
use League\OAuth2\Client\Provider\TwscResourceOwner;
use League\OAuth2\Client\Provider\ValueObjects\Repair;
use League\OAuth2\Client\Token\AccessToken;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class TwscTest extends TestCase
{
    /**
     * @var Twsc
     */
    protected $provider;
    protected $apiVersion = 'v2';

    protected function setUp(): void
    {
        $this->provider = new \League\OAuth2\Client\Provider\Twsc(
            [
                'clientId' => 'mock_client_id',
                'clientSecret' => 'mock_secret',
                'redirectUri' => 'none',
            ]
        );
    }

    public function tearDown(): void
    {
        m::close();
        parent::tearDown();
    }

    public function testCallApiMethodGet()
    {
        $result = ['email' => 'john.smith@e.mail'];
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $stream = m::mock('Psr\Http\Message\StreamInterface');
        $stream->shouldReceive('getContents')->times(1)->andReturn(json_encode($result));
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->times(1)->andReturn($stream);
        $provider = $this->getMockBuilder(
            Twsc::class)
            ->onlyMethods(
                ['createRequest', 'getResponse']
            )->getMock();
        $provider->expects($this->once())
            ->method('createRequest')
            ->with(
                $this->equalTo(Twsc::METHOD_GET),
                $this->equalTo('https://api.twsc.nl/v1/profile/me'),
                $this->equalTo($accessToken),
                $this->equalTo([
                        'headers' => [
                            'Accept' => 'application/json',
                            'Accept-Encoding' => 'gzip'
                        ]]
                )
            )
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
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $stream = m::mock('Psr\Http\Message\StreamInterface');
        $stream->shouldReceive('getContents')->times(1)->andReturn(json_encode($result));
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->times(1)->andReturn($stream);
        $provider = $this->getMockBuilder(
            Twsc::class)
            ->onlyMethods(
                ['createRequest', 'getResponse']
            )->getMock();
        $provider->expects($this->once())
            ->method('createRequest')
            ->with(
                $this->equalTo(Twsc::METHOD_POST),
                $this->equalTo('https://api.twsc.nl/v1/profile/me/repairs'),
                $this->equalTo($accessToken),
                $this->equalTo([
                        'body' => json_encode($body),
                        'headers' => [
                            'Accept' => 'application/json',
                            'Accept-Encoding' => 'gzip',
                            'Content-Type' => 'application/json'
                        ]]
                )
            )
            ->will($this->returnValue($request));
        $provider->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo($request))
            ->will($this->returnValue($response));
        $resultReturned = $provider->callApi($accessToken, Twsc::METHOD_POST, '/profile/me/repairs', $body);
        $this->assertEquals($result, $resultReturned);
    }

    public function testCallApiMethodPut()
    {
        $body = new Repair();
        $result = ['email' => 'john.smith@e.mail'];
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $stream = m::mock('Psr\Http\Message\StreamInterface');
        $stream->shouldReceive('getContents')->times(1)->andReturn(json_encode($result));
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->times(1)->andReturn($stream);
        $provider = $this->getMockBuilder(
            Twsc::class)
            ->onlyMethods(
                ['createRequest', 'getResponse']
            )->getMock();
        $provider->expects($this->once())
            ->method('createRequest')
            ->with(
                $this->equalTo(Twsc::METHOD_PUT),
                $this->equalTo('https://api.twsc.nl/v1/profile/me/repairs'),
                $this->equalTo($accessToken),
                $this->equalTo([
                    'body' => json_encode($body),
                    'headers' => [
                        'Accept' => 'application/json',
                        'Accept-Encoding' => 'gzip',
                            'Content-Type' => 'application/json'
                    ]
                ])
            )
            ->will($this->returnValue($request));
        $provider->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo($request))
            ->will($this->returnValue($response));
        $resultReturned = $provider->callApi($accessToken, Twsc::METHOD_PUT, '/profile/me/repairs', $body);
        $this->assertEquals($result, $resultReturned);
    }

    public function testCallApiShouldThrowServerError()
    {
        $this->expectException(\League\OAuth2\Client\Provider\ClientErrorException::class);
        $this->expectExceptionMessage('Server error');
        $result = ['error' => true, 'message' => 'Server error', 'message_nl' => 'NL'];
        $accessToken = m::mock('League\OAuth2\Client\Token\AccessToken');
        $request = m::mock('Psr\Http\Message\ServerRequestInterface');
        $stream = m::mock('Psr\Http\Message\StreamInterface');
        $stream->shouldReceive('getContents')->times(1)->andReturn(json_encode($result));
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->times(1)->andReturn($stream);
        $provider = $this->getMockBuilder(
            Twsc::class)
            ->onlyMethods(
                ['createRequest', 'getResponse']
            )->getMock();
        $provider->expects($this->once())
            ->method('createRequest')
            ->with(
                $this->equalTo(Twsc::METHOD_GET),
                $this->equalTo('https://api.twsc.nl/v1/profile/me'),
                $this->equalTo($accessToken),
                $this->equalTo([
                    'headers' => [
                        'Accept' => 'application/json',
                        'Accept-Encoding' => 'gzip'
                    ]
                ]))
            ->will($this->returnValue($request));
        $provider->expects($this->once())
            ->method('getResponse')
            ->with($this->equalTo($request))
            ->will($this->returnValue($response));
        $resultReturned = $provider->callApi($accessToken, Twsc::METHOD_GET, '/profile/me');
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
        $url = $this->provider->getAuthorizationUrl($options);
        $this->assertStringContainsString(urlencode(implode(',', $options['scope'])), $url);
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
        $url = $this->provider->getBaseAccessTokenUrl($params);
        $uri = parse_url($url);
        $this->assertEquals('/oauth/token', $uri['path']);
    }

    public function testGetAccessToken()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn(
            Utils::streamFor('{"access_token":"mock_access_token", "scope":"repo,gist", "token_type":"bearer"}')
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
            Utils::streamFor('access_token=mock_access_token&expires=3600&refresh_token=mock_refresh_token&otherKey={1234}')
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
            $provider->getBaseTwscApiUrl() . '/' . $this->apiVersion . '/profile/me',
            $provider->getResourceOwnerDetailsUrl($token)
        );
        $this->assertEquals(
            $provider->getApiVersion(),
            $this->apiVersion
        );

    }

    public function testUserData()
    {
        $userId = rand(1000, 9999);
        $firstName = uniqid();
        $lastName = uniqid();
        $email = uniqid();
        $premium = false;

        $postResponse = m::mock('Psr\Http\Message\ResponseInterface');
        $postResponse->shouldReceive('getBody')->andReturn(
            Utils::streamFor('access_token=mock_access_token&expires=3600&refresh_token=mock_refresh_token&otherKey={1234}')
        );
        $postResponse->shouldReceive('getHeader')->andReturn(['content-type' => 'application/x-www-form-urlencoded']);
        $postResponse->shouldReceive('getStatusCode')->andReturn(200);
        $userResponse = m::mock('Psr\Http\Message\ResponseInterface');
        $userResponse->shouldReceive('getBody')->andReturn(
            Utils::streamFor('{"id": ' . $userId . ', "firstname": "' . $firstName . '", "lastname": "' . $lastName . '", "email": "' . $email . '", "premium": "' . $premium . '"}')
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
        $user = $this->provider->getResourceOwner($token);
        $this->assertEquals($userId, $user->getId());
        $this->assertEquals($userId, $user->toArray()['id']);
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($firstName, $user->toArray()['firstname']);
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($lastName, $user->toArray()['lastname']);
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($email, $user->toArray()['email']);
    }

    public function testExceptionThrownWhenErrorObjectReceived()
    {
        $this->expectException(\League\OAuth2\Client\Provider\Exception\IdentityProviderException::class);
        $message = uniqid();
        $status = rand(400, 600);

        $postResponse = m::mock('Psr\Http\Message\ResponseInterface');
        $postResponse->shouldReceive('getBody')->andReturn(Utils::streamFor(' {"message":"' . $message . '"}'));
        $postResponse->shouldReceive('getHeader')->andReturn(['content-type' => 'json']);
        $postResponse->shouldReceive('getStatusCode')->andReturn($status);

        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')
            ->times(1)
            ->andReturn($postResponse);

        $this->provider->setHttpClient($client);
        $this->provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);
    }

    /**
     * Builds a Twsc mock whose createRequest/getResponse are stubbed.
     *
     * @param callable|null $optionsAssertion receives the $options passed to createRequest
     */
    private function mockProvider($getResponse, callable $optionsAssertion = null, array $constructorOptions = [])
    {
        $request = new Request('GET', 'https://api.twsc.nl');
        $provider = $this->getMockBuilder(Twsc::class)
            ->setConstructorArgs([$constructorOptions])
            ->onlyMethods(['createRequest', 'getResponse'])
            ->getMock();
        $provider->expects($this->once())
            ->method('createRequest')
            ->willReturnCallback(function ($method, $url, $token, $options) use ($request, $optionsAssertion) {
                if ($optionsAssertion) {
                    $optionsAssertion($method, $url, $options);
                }
                return $request;
            });
        $mocker = $provider->expects($this->once())->method('getResponse')->with($this->identicalTo($request));
        if ($getResponse instanceof \Throwable) {
            $mocker->willThrowException($getResponse);
        } else {
            $mocker->willReturn($getResponse);
        }
        return $provider;
    }

    public function testCallApiMethodDeleteSendsDefaultHeadersWithoutBody()
    {
        $accessToken = m::mock(AccessToken::class);
        $provider = $this->mockProvider(
            new Response(200, [], json_encode(['deleted' => true])),
            function ($method, $url, $options) {
                $this->assertSame(Twsc::METHOD_DELETE, $method);
                $this->assertSame('https://api.twsc.nl/v1/profile/me', $url);
                $this->assertArrayNotHasKey('body', $options);
                $this->assertSame(
                    ['Accept' => 'application/json', 'Accept-Encoding' => 'gzip'],
                    $options['headers']
                );
            }
        );

        $this->assertSame(['deleted' => true], $provider->callApi($accessToken, Twsc::METHOD_DELETE, '/profile/me'));
    }

    public function testCallApiPostWithoutBodySendsJsonNull()
    {
        $accessToken = m::mock(AccessToken::class);
        $provider = $this->mockProvider(
            new Response(200, [], '{}'),
            function ($method, $url, $options) {
                $this->assertSame('null', $options['body']);
                $this->assertSame('application/json', $options['headers']['Content-Type']);
            }
        );

        $provider->callApi($accessToken, Twsc::METHOD_POST, '/workshop/rate/1');
    }

    public function testCallApiReturnsDataWhenErrorFlagIsFalse()
    {
        $accessToken = m::mock(AccessToken::class);
        $data = ['error' => false, 'message' => 'all good'];
        $provider = $this->mockProvider(new Response(200, [], json_encode($data)));

        $this->assertSame($data, $provider->callApi($accessToken, 'GET', '/profile/me'));
    }

    public function testCallApiReturnsNullForEmptyBody()
    {
        $accessToken = m::mock(AccessToken::class);
        $provider = $this->mockProvider(new Response(204, [], ''));

        $this->assertNull($provider->callApi($accessToken, Twsc::METHOD_DELETE, '/profile/me'));
    }

    public function testCallApiUsesConfiguredApiUrlAndVersion()
    {
        $accessToken = m::mock(AccessToken::class);
        $provider = $this->mockProvider(
            new Response(200, [], '{}'),
            function ($method, $url) {
                $this->assertSame('https://api.example.test/v2/customers/1', $url);
            },
            ['base_twsc_api_url' => 'https://api.example.test', 'api_version' => 'v2']
        );

        $provider->callApi($accessToken, 'GET', '/customers/1');
    }

    public function testCallApiConvertsGuzzleClientExceptionWithErrorPayload()
    {
        $accessToken = m::mock(AccessToken::class);
        $payload = ['error' => true, 'message' => 'Invalid repair', 'message_nl' => 'Ongeldige reparatie',
            'code' => 422, 'reason' => 'validation'];
        $guzzleException = new ClientException(
            'Unprocessable',
            new Request('POST', 'https://api.twsc.nl'),
            new Response(422, [], json_encode($payload))
        );
        $provider = $this->mockProvider($guzzleException);

        try {
            $provider->callApi($accessToken, Twsc::METHOD_POST, '/customers/1/repairs', new Repair());
            $this->fail('Expected ClientErrorException');
        } catch (ClientErrorException $e) {
            $this->assertSame('Invalid repair', $e->getMessage());
            $this->assertSame('Ongeldige reparatie', $e->getMessageNL());
            $this->assertSame(422, $e->getCode());
            $this->assertSame('validation', $e->getReason());
        }
    }

    public function testCallApiRethrowsGuzzleClientExceptionWithoutErrorPayload()
    {
        $accessToken = m::mock(AccessToken::class);
        $guzzleException = new ClientException(
            'Not Found',
            new Request('GET', 'https://api.twsc.nl'),
            new Response(404, [], 'Not Found')
        );
        $provider = $this->mockProvider($guzzleException);

        try {
            $provider->callApi($accessToken, 'GET', '/customers/999');
            $this->fail('Expected ClientException');
        } catch (ClientException $e) {
            $this->assertSame($guzzleException, $e);
        }
    }

    public function testConstructorOverridesBaseUrlsAndApiVersion()
    {
        $provider = new Twsc([
            'base_twsc_oauth2_url' => 'https://accounts.example.test',
            'base_twsc_api_url' => 'https://api.example.test',
            'api_version' => 'v2',
        ]);
        $token = new AccessToken(['access_token' => 'abc']);

        $this->assertSame('https://accounts.example.test', $provider->getBaseTwscOauthUrl());
        $this->assertSame('https://api.example.test', $provider->getBaseTwscApiUrl());
        $this->assertSame('v2', $provider->getApiVersion());
        $this->assertSame('https://accounts.example.test/oauth/authorize', $provider->getBaseAuthorizationUrl());
        $this->assertSame('https://accounts.example.test/oauth/token', $provider->getBaseAccessTokenUrl([]));
        $this->assertSame('https://api.example.test/v2/profile/me', $provider->getResourceOwnerDetailsUrl($token));
    }

    public function testConstructorAcceptsCamelCaseApiVersion()
    {
        $provider = new Twsc(['apiVersion' => 'v9']);

        $this->assertSame('v9', $provider->getApiVersion());
    }

    public function testSnakeCaseApiVersionWinsOverCamelCase()
    {
        $provider = new Twsc(['apiVersion' => 'v9', 'api_version' => 'v3']);

        $this->assertSame('v3', $provider->getApiVersion());
    }

    public function testConstructorDefaults()
    {
        $provider = new Twsc();

        $this->assertSame('https://accounts.twsc.nl', $provider->getBaseTwscOauthUrl());
        $this->assertSame('https://api.twsc.nl', $provider->getBaseTwscApiUrl());
        $this->assertSame('v1', $provider->getApiVersion());
    }

    public function testDefaultScopeIsProfile()
    {
        $url = $this->provider->getAuthorizationUrl();
        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        $this->assertSame('profile', $query['scope']);
    }

    public function testAuthorizationHeadersUseBearerToken()
    {
        $token = new AccessToken(['access_token' => 'mock_token']);
        $headers = $this->provider->getHeaders($token);

        $this->assertSame('Bearer mock_token', $headers['Authorization']);
    }

    public function testCheckResponseFallsBackToReasonPhrase()
    {
        $response = new Response(503, ['content-type' => 'application/json'], '{}', '1.1', 'Service Unavailable');
        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->once()->andReturn($response);
        $this->provider->setHttpClient($client);

        try {
            $this->provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);
            $this->fail('Expected IdentityProviderException');
        } catch (IdentityProviderException $e) {
            $this->assertSame('Service Unavailable', $e->getMessage());
            $this->assertSame(503, $e->getCode());
            $this->assertSame($response, $e->getResponseBody());
        }
    }

    public function testCheckResponseUsesMessageFromBody()
    {
        $response = new Response(401, ['content-type' => 'application/json'], '{"message":"Invalid code"}');
        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->once()->andReturn($response);
        $this->provider->setHttpClient($client);

        try {
            $this->provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);
            $this->fail('Expected IdentityProviderException');
        } catch (IdentityProviderException $e) {
            $this->assertSame('Invalid code', $e->getMessage());
            $this->assertSame(401, $e->getCode());
        }
    }

    public function testGetResourceOwnerReturnsTwscResourceOwner()
    {
        $response = new Response(
            200,
            ['content-type' => 'application/json'],
            '{"id": 1, "firstname": "John", "lastname": "Smith", "email": "john@e.mail"}'
        );
        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->once()->andReturn($response);
        $this->provider->setHttpClient($client);

        $owner = $this->provider->getResourceOwner(new AccessToken(['access_token' => 'abc']));

        $this->assertInstanceOf(TwscResourceOwner::class, $owner);
        $this->assertSame(1, $owner->getId());
    }
}
