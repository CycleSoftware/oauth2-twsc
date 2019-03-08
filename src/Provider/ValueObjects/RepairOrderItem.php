<?php
namespace League\OAuth2\Client\Provider\ValueObjects;

class RepairOrderItem
{
    /**
     * @var int
     */
    public $item_id;
    /**
     * @var int
     */
    public $item_type_id;
    /**
     * @var int
     */
    public $special_type_id;
    /**
     * @var int|float
     */
    public $quantity;
    /**
     * @var string
     */
    public $barcode;
    /**
     * @var int
     */
    public $pos_group_id;
    /**
     * @var string
     */
    public $description;
    /**
     * @var int
     */
    public $unit_price_in_vat_cents;
    /**
     * @var int
     */
    public $unit_discount_amount_in_vat_cents;
    /**
     * @var int
     */
    public $price_in_vat_cents;
    /**
     * @var float
     */
    public $discount_percentage;
    /**
     * @var int
     */
    public $vat_code;
    /**
     * @var float
     */
    public $vat_percentage;
    /**
     * @var int
     */
    public $vat_amount_cents;
    /**
     * @var int
     */
    public $item_status_id;
    /**
     * @var string
     */
    public $item_status_text;

    /**
     * @var int
     */
    public $unit_work_time_minutes = 0;
}