<?php

declare(strict_types=1);

namespace Yiisoft\ActiveRecord\Tests\Stubs;

use Yiisoft\ActiveRecord\ActiveQuery;

/**
 * OrderWithConstructor.
 *
 * @property int $id
 * @property int $customer_id
 * @property int $created_at
 * @property string $total
 *
 * @property OrderItemWithConstructor $orderItems
 * @property CustomerWithConstructor $customer
 * @property CustomerWithConstructor $customerJoinedWithProfile
 */
class OrderWithConstructor extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'order';
    }

    public function __construct($id)
    {
        $this->id = $id;
        $this->created_at = time();

        parent::__construct();
    }

    public static function instance($refresh = false): ActiveRecord
    {
        return self::instantiate([]);
    }

    public static function instantiate($row): ActiveRecord
    {
        return (new \ReflectionClass(static::class))->newInstanceWithoutConstructor();
    }

    public function getCustomer(): ActiveQuery
    {
        return $this->hasOne(CustomerWithConstructor::class, ['id' => 'customer_id']);
    }

    public function getCustomerJoinedWithProfile(): ActiveQuery
    {
        return $this->hasOne(CustomerWithConstructor::class, ['id' => 'customer_id'])
            ->joinWith('profile');
    }

    public function getOrderItems(): ActiveQuery
    {
        return $this->hasMany(OrderItemWithConstructor::class, ['order_id' => 'id'])->inverseOf('order');
    }
}
