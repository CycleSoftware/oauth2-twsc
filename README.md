# CycleSoftware Twsc Provider and Client for accessing TWSC Api Resources

This package provides CycleSoftware TWSC Api support using PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Install

Via Composer

``` bash
$ composer require cyclesoftware/oauth2-twsc
```

## Usage with authorization grant

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
        print_r($result);

    } catch (Exception $e) {
        // Failed to get resources
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```
Class Client has lot of implemented methods for getting resources from server. 

There are two create and update methods to create new objects and update existing ones.
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
        print_r($repairObjectId);
    } catch (Exception $e) {
        // Failed to create repair object
        exit('Oh dear...');
    }
```   

## Usage with client_credentials grant
When using a credentials grant the first step is to obtain an AccessToken. 
``` php

try {
    $provider = new League\OAuth2\Client\Provider\Twsc([
        'clientId'     => '{cs-client-id}',
        'clientSecret' => '{cs-client-secret}',
    ]);  
    $access_token = $provider->getAccessToken('client_credentials');
    $customer = new Customer();
    $customer->customer_reference = ''; // e.g. your customer number
    $customer->postcode = '100AM';
    $customer->house_number = '1';
    $customer->house_number_postfix = '2';
    $customer->title = 'Dhr.';
    $customer->initials = 'A';
    $customer->insertion = 'van';
    $customer->name = 'Laak';
    $customer->street = 'Hoofdweg';
    $customer->city = 'Amsterdam';
    $customer->country_code_iso_3166 = 'NL';
    $customer->email = 'email@mail.com';
    $customer->discount_percentage = 10;
    $customer_phones = [];
    $customer_phone = new CustomerPhone();
    $customer_phone->phone_number = '+31612345678';
    $customer_phones[] = $customer_phone;
    $customer_phone = new CustomerPhone();
    $customer_phone->phone_number = '+3173030050';
    $customer_phones[] = $customer_phone;
    $customer->phone_numbers = $customer_phones;
    $client = new Client($provider);
    $result = $client->createCustomer($access_token, $customer);
} catch(League\OAuth2\Client\Provider\ClientErrorException $e){
    // ClientErrorException gives you information about what went wrong
    // echo $e->getMessage();
    // echo $e->getReason();
    // echo $e->getMessageNL();
}
```


## Create a Repair Order
``` php

try {
    $provider = new League\OAuth2\Client\Provider\Twsc([
        'clientId' => '{cs-client-id}',
        'clientSecret' => '{cs-client-secret}',
    ]);
    $access_token = $provider->getAccessToken('client_credentials');
    $repair = new Repair();
    $repair->customer_id = 24;
    $repair->repair_object_id = 1105;
    $repair->reference_text = 'some-reference'; // your reference
    $repair->datetime_scheduled_start = '2019-03-11T15:41:46+01:00';
    $repair->mechanic_employee_id = 1; // default for TWSC 1
    $repair->repair_description = 'Some description of the repair order';
    /**
     * Status:
     * STATUS_WAIT_FOR_OBJECT = 1;
     * STATUS_WAIT_FOR_REPAIR = 2;
     * STATUS_WAIT_FOR_ARTICLES = 3;
     * STATUS_IN_REPAIR = 4;
     * STATUS_WAIT_FOR_CUSTOMER = 5;
     * STATUS_WAIT_FOR_INVOICE = 6;
     * STATUS_COMPLETED = 7;
     * STATUS_DONE = 8;
     * STATUS_WAIT_FOR_SUPPLIER = 9;
     * STATUS_WAIT_FOR_OBJECT_ONLINE = 10;
     * STATUS_WAIT_FOR_INSURANCE = 11;
     * STATUS_WAIT_FOR_INSURANCE_EXPERT = 12;
     * STATUS_PICKUP_AT_CUSTOMER = 13;
     * STATUS_WAIT_FOR_OBJECT_SUPPLIER = 14;
     * STATUS_CANCELLED = 15;
     * STATUS_DECLINED = 16;
     */
    $repair->status_id = 10; // default: 10  
    $repair->custom_repair_time_minutes = 0; // time not related to order_items

    // add a normal article
    $item = new RepairOrderItem();
    $item->item_type_id = 1; // 1: Article, 4: RepairCode
    $item->special_type_id = 1;
    $item->quantity = 1;
    $item->barcode = '8712812812';
    $item->pos_group_id = 2; // 2: Repair, 21: Parts
    $item->description = 'In- en uitbouwen electromotor in- en uitbouwen accu';
    $item->unit_price_in_vat_cents = 12100;
    $item->unit_discount_amount_in_vat_cents = 0;
    $item->price_in_vat_cents = 12100;
    $item->discount_percentage = 0;
    $item->vat_code = 2; // 1: LOW VAT; 2: HIGH VAT, 0: NO VAT
    $item->vat_percentage = 21.0;
    $item->vat_amount_cents = 2100;
    $item->item_status_id = 0; // 0: No status, 1: Ordered at supplier 2: Ready for pickup 3: Delivered 4: Picked up 5: Cancelled
    $item->unit_work_time_minutes = 15;
    $repair->order_items[] = $item;

    $client = new Client($provider);
    $result = $client->createRepair($access_token, $repair);
}
catch (League\OAuth2\Client\Provider\ClientErrorException $e) {
    // ClientErrorException gives you information about what went wrong
    // echo $e->getMessage();
    // echo $e->getReason();
    // echo $e->getMessageNL();
}
```

## Update a Repair Order With Order items

Make sure that service_items and repair_codes have the value null. 
Only the order_item provided in the array order_items are updated. When adding new order items, leave item_id=null.
When an existing order_item is omitted in the PUT, it will not be deleted or updated. To cancel an item use item_status_id=5


## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
