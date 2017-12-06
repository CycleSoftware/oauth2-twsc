<?php
namespace League\OAuth2\Client\Provider\ValueObjects;

class Customer
{
    public $customer_id;
    public $customer_type_name;
    public $customer_reference;
    public $postcode;
    public $house_number;
    public $house_number_postfix;
    public $attn;
    public $initials;
    public $insertion;
    public $name;
    public $street;
    public $city;
    public $country;
    public $country_code_iso_3166;
    public $email;
    public $discount_percentage;
    public $datetime_created;
    public $title;
    /** @var  CustomerPhone[] $phone_numbers */
    public $phone_numbers;
}
