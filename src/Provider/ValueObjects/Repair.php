<?php

namespace League\OAuth2\Client\Provider\ValueObjects;

class Repair
{
    /**
     * @var int
     */
    public $customer_order_repair_id;
    /**
     * @var int
     */
    public $customer_order_id;
    /**
     * @var int
     */
    public $customer_id;
    /**
     * @var int
     */
    public $store_id;
    /**
     * @var int
     */
    public $repair_object_id;
    /**
     * @var bool
     */
    public $is_active = true;
    /**
     * @var string
     */
    public $reference_text;
    /**
     * @var string date ISO8601
     */
    public $datetime_scheduled_start;
    /**
     * @var string date ISO8601
     */
    public $datetime_scheduled_finished;
    /**
     * @var string date ISO8601
     */
    public $datetime_created;
    /**
     * @var string date ISO8601
     */
    public $datetime_modified;
    /**
     * @var int
     */
    public $mechanic_employee_id;
    /**
     * @var int
     */
    public $created_by_employee_id;
    /**
     * @var int
     */
    public $last_update_employee_id;
    /**
     * @var string
     */
    public $phone_number_id;
    /**
     * @var string
     */
    public $repair_description;
    /**
     * @var int
     */
    public $status_id;
    /**
     * @var string
     */
    public $status_text;
    /**
     * @var int
     */
    public $invoice_number;
    /**
     * @var string
     */
    public $borrowed_object_reference;
    /**
     * @var int
     */
    public $total_repair_time_minutes;
    /**
     * @var  int
     */
    public $custom_repair_time_minutes;

    /**
     * @var int
     */
    public $delivery_method_id = 0;

    /**
     * @var string[]
     */
    public $repair_codes = [];
    /**
     * @var string[]
     */
    public $service_card_codes = [];
    /**
     * @var RepairOrderItem[]
     */
    public $order_items = [];

}
