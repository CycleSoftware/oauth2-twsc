<?php
namespace League\OAuth2\Client\Provider;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Twsc extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /** @var string */
    public $base_twsc_oauth2_url = 'https://accounts.twsc.nl';
    /** @var string */
    public $base_twsc_api_url = 'https://accounts.twsc.nl';

    /** @var string */
    protected $api_version = 'v1';

    /**
     * Constructs an OAuth 2.0 service provider.
     *
     * @param array $options An array of options to set on this provider.
     *     Options include `clientId`, `clientSecret`, `redirectUri`, `state`, `api_version`.
     *     Individual providers may introduce more options, as needed.
     * @param array $collaborators An array of collaborators that may be used to
     *     override this provider's default behavior. Collaborators include
     *     `grantFactory`, `requestFactory`, `httpClient`, and `randomFactory`.
     *     Individual providers may introduce more collaborators, as needed.
     */
    public function __construct(array $options = [], array $collaborators = [])
    {
        parent::__construct($options, $collaborators);

        foreach ($options as $option => $value) {
            if (property_exists($this, $option)) {
                $this->{$option} = $value;
            }
        }
    }

    /**
     * Get authorization url to begin OAuth flow
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return $this->base_twsc_oauth2_url . '/oauth/authorize';
    }

    /**
     * Get access token url to retrieve token
     *
     * @param  array $params
     *
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return $this->base_twsc_oauth2_url . '/oauth/token';
    }


    public function post_something(string $uri, $token, string $body)
    {
        $uri = 'http://5m-2.dev.accounts.twsc.nl/oauth/test_server';
        $options['body'] = 'hello';
        $request = $this->createRequest(self::METHOD_POST, $uri, $token, $options);
        $response = $this->getResponse($request);
        $contents = $response->getBody()->getContents();
        echo $contents;
    }

    public function put_something(string $uri, $token, string $body)
    {
        $uri = 'http://5m-2.dev.accounts.twsc.nl/oauth/test_server';
        $options['body'] = json_encode(['a'=>1, 'b'=>2]);
        $request = $this->createRequest('PUT', $uri, $token, $options);
        $response = $this->getResponse($request);
        var_export(json_decode($response->getBody()->getContents()));
    }
    /**
     * Get provider url to fetch user details
     *
     * @param  AccessToken $token
     *
     * @return string
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        return $this->base_twsc_api_url . '/' . $this->api_version . '/me';
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return array
     */
    protected function getDefaultScopes()
    {
        return ['profile'];
    }

    /**
     * Check a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $data['message'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $response
            );
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return \League\OAuth2\Client\Provider\ResourceOwnerInterface
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        return new TwscResourceOwner($response);
    }

    /**
     * @return string
     */
    public function getBaseTwscOauthUrl()
    {
        return $this->base_twsc_oauth2_url;
    }

    /**
     * @return string
     */
    public function getBaseTwscApiUrl()
    {
        return $this->base_twsc_api_url;
    }

    /**
     * @return string
     */
    public function getApiVersion()
    {
        return $this->api_version;
    }

    /**
     * Returns the default headers used by this provider.
     *
     * Typically this is used to set 'Accept' or 'Content-Type' headers.
     *
     * @return array
     */
    protected function getDefaultHeaders()
    {
        return [
            'Accept' => 'application/json',
            'Accept-Encoding' => 'gzip',
        ];
    }
}
