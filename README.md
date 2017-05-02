# CycleSoftware Twsc Provider and Client for accessing TWSC Api Resources

This package provides CycleSoftware TWSC Api support using PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Install

Via Composer

``` bash
$ composer require cyclesoftware/oauth2-twsc
```

## Usage

Usage scenario is very similar to the one for The League's OAuth client, using `\League\OAuth2\Client\Provider\Twsc` as the provider.

``` php
$provider = new League\OAuth2\Client\Provider\Twsc([
    'clientId'     => '{cs-client-id}',
    'clientSecret' => '{cs-client-secret}',
    'redirectUri'  => 'https://example.com/callback-url',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, now we can access resources on TWSC Api 
        // First create client
        $client = new League\OAuth2\Client\Provider\Client($provider);
        // now we can get list of available repair codes
        $result = $client->getRepairCodes($token);
        // We have list of repair codes 
        printr($result);

    } catch (Exception $e) {
        // Failed to get resources
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```
Class Client has lot of implemented methods for getting resources from server. There are two create and update methods to create new objects and update existing ones.
We illustrate creation of RepairObject using Client. Scenario is pretty much as the previous, and we assume that we already have access token.

``` php
    try {

        // We got an access token, now we can access resources on TWSC Api 
        // First create client
        $client = new League\OAuth2\Client\Provider\Client($provider);
        // Create RepairObject instance
        $repairObject = new League\OAuth2\Client\Provider\ValueObjects\RepairObject();
        // Fill repairObject fields
        $repairObject->is_active = 1;
        $repairObject->object_barcode = '3600 2600';
        $repairObject->customer_id = 2002;
        $repairObject->object_type_name = 'bicycle';
        $repairObject->brand = 'A-bike';
        $repairObject->model = 'mountain bike';
        $repairObject->color = 'red';
        $repairObject->phone_number_id = '12345';
        $repairObject->license_plate = 'nl 1234';
        $repairObject->km_mileage = '200';
        $repairObject->frame_id = 'HK6429';
        $repairObject->chip_id = '4321';
        $repairObject->key_id = '1234';
        $repairObject->engine_id = '4321';
        $repairObject->model_year = '2017';
        $repairObject->battery_id = '1234';
        $repairObject->lock_id = '4321';
        // Now we can create repair object on the server
        $repairObjectId = $client->createRepairObject($token, $repairObject);
        // We got repair object identifier 
        printr($repairObjectId);
    } catch (Exception $e) {
        // Failed to create repair object
        exit('Oh dear...');
    }
```   

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
