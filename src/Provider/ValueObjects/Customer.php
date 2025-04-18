<?php
namespace League\OAuth2\Client\Provider\ValueObjects;

#[\AllowDynamicProperties]
class Customer
{
    public $customer_id;
    public $customer_type_name;
    public $customer_reference;
    public $title;
    public $attn;
    public $initials;
    public $first_name;
    public $insertion;
    public $name;
    public $street;
    public $postcode;
    public $house_number;
    public $house_number_postfix;
    public $city;
    public $country_code_iso_3166;
    public $email;
    public $discount_percentage;
    public $datetime_created;
    /** @var  CustomerPhone[] $phone_numbers */
    public $phone_numbers;
    public $company_name;
    public $coc_number;
    public $vat_number;
}
