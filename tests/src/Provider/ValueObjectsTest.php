<?php

namespace League\OAuth2\Client\Test\Provider;

use League\OAuth2\Client\Provider\ValueObjects\Customer;
use League\OAuth2\Client\Provider\ValueObjects\CustomerPhone;
use League\OAuth2\Client\Provider\ValueObjects\Repair;
use League\OAuth2\Client\Provider\ValueObjects\RepairObject;
use League\OAuth2\Client\Provider\ValueObjects\RepairOrderItem;
use PHPUnit\Framework\TestCase;

class ValueObjectsTest extends TestCase
{
    public function testRepairDefaults()
    {
        $repair = new Repair();

        $this->assertTrue($repair->is_active);
        $this->assertSame(0, $repair->delivery_method_id);
        $this->assertSame([], $repair->repair_codes);
        $this->assertSame([], $repair->service_card_codes);
        $this->assertSame([], $repair->order_items);
        $this->assertNull($repair->customer_order_repair_id);
        $this->assertNull($repair->customer_id);
    }

    public function testRepairOrderItemDefaults()
    {
        $item = new RepairOrderItem();

        $this->assertSame(0, $item->unit_work_time_minutes);
        $this->assertNull($item->item_id);
    }

    /**
     * @dataProvider valueObjectProvider
     */
    public function testAllPublicPropertiesAreSerializedToJson($class, array $expectedProperties)
    {
        $decoded = json_decode(json_encode(new $class()), true);

        foreach ($expectedProperties as $property) {
            $this->assertArrayHasKey($property, $decoded, "$class::\$$property missing in JSON");
        }
        $this->assertCount(count(get_class_vars($class)), $decoded);
    }

    public function valueObjectProvider()
    {
        return [
            'Customer' => [Customer::class, [
                'customer_id', 'customer_type_name', 'customer_reference', 'title', 'attn', 'initials',
                'first_name', 'insertion', 'name', 'street', 'postcode', 'house_number',
                'house_number_postfix', 'city', 'country_code_iso_3166', 'email', 'discount_percentage',
                'datetime_created', 'phone_numbers', 'company_name', 'coc_number', 'vat_number',
            ]],
            'CustomerPhone' => [CustomerPhone::class, [
                'phone_number_id', 'customer_id', 'phone_number', 'name',
            ]],
            'Repair' => [Repair::class, [
                'customer_order_repair_id', 'customer_order_id', 'customer_id', 'store_id',
                'repair_object_id', 'is_active', 'reference_text', 'datetime_scheduled_start',
                'datetime_scheduled_finished', 'datetime_created', 'datetime_modified',
                'mechanic_employee_id', 'created_by_employee_id', 'last_update_employee_id',
                'phone_number_id', 'repair_description', 'status_id', 'status_text', 'invoice_number',
                'borrowed_object_reference', 'total_repair_time_minutes', 'custom_repair_time_minutes',
                'delivery_method_id', 'repair_codes', 'service_card_codes', 'order_items',
            ]],
            'RepairObject' => [RepairObject::class, [
                'customer_id', 'object_id', 'object_barcode', 'is_active', 'object_type_name', 'category',
                'brand', 'model', 'model_year', 'color', 'variant', 'phone_number_id', 'license_plate',
                'km_mileage', 'lease_contract_number', 'lease_employer_customer_id',
                'lease_fleet_customer_id', 'frame_id', 'chip_id', 'key_id', 'engine_id', 'battery_id',
                'lock_id', 'service_level_id', 'repair_rate_id', 'images',
            ]],
            'RepairOrderItem' => [RepairOrderItem::class, [
                'item_id', 'item_type_id', 'special_type_id', 'quantity', 'barcode', 'pos_group_id',
                'description', 'unit_price_in_vat_cents', 'unit_discount_amount_in_vat_cents',
                'price_in_vat_cents', 'discount_percentage', 'vat_code', 'vat_percentage',
                'vat_amount_cents', 'item_status_id', 'item_status_text', 'unit_work_time_minutes',
            ]],
        ];
    }

    public function testCustomerAllowsDynamicProperties()
    {
        $customer = new Customer();
        $customer->some_new_api_field = 'value';

        $this->assertSame('value', $customer->some_new_api_field);
        $this->assertSame('value', json_decode(json_encode($customer), true)['some_new_api_field']);
    }

    public function testRepairWithNestedOrderItemsSerializes()
    {
        $item = new RepairOrderItem();
        $item->item_id = 5;
        $item->quantity = 2;
        $repair = new Repair();
        $repair->customer_id = 1000;
        $repair->repair_codes = ['A1'];
        $repair->order_items = [$item];

        $decoded = json_decode(json_encode($repair), true);

        $this->assertSame(1000, $decoded['customer_id']);
        $this->assertSame(['A1'], $decoded['repair_codes']);
        $this->assertSame(5, $decoded['order_items'][0]['item_id']);
        $this->assertSame(2, $decoded['order_items'][0]['quantity']);
    }
}
