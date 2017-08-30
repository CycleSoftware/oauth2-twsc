<?php
namespace League\OAuth2\Client\Provider\ValueObjects;

class Repair
{
    public $customer_order_repair_id;
    public $customer_order_id;
    public $customer_id;
    public $store_id;
    public $repair_object_id;
    public $is_active;
    public $reference_text;
    public $datetime_scheduled_start;
    public $datetime_scheduled_finished;
    public $datetime_created;
    public $datetime_modified;
    public $mechanic_employee_id;
    public $created_by_employee_id;
    public $last_update_employee_id;
    public $phone_number_id;
    public $repair_description;
    public $status_id;
    public $status_text;
    public $invoice_number;
    public $total_repair_time_minutes;
    public $custom_repair_time_minutes;
    public $repair_codes = [];
    public $service_card_item = [];
}
