<?php

declare(strict_types=1);

namespace Yiisoft\ActiveRecord\Tests\Stubs;

use Yiisoft\ActiveRecord\ActiveQuery;

/**
 * Class Customer.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $address
 * @property int $status
 *
 * @method CustomerQuery findBySql($sql, $params = []) static
 */
class Customer extends ActiveRecord
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public $status2;
    public $sumTotal;

    public static function tableName(): string
    {
        return 'customer';
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(Profile::class, ['id' => 'profile_id']);
    }

    public function getOrdersPlain(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['customer_id' => 'id']);
    }

    public function getOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['customer_id' => 'id'])->orderBy('id');
    }

    public function getExpensiveOrders(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['customer_id' => 'id'])->andWhere('[[total]] > 50')->orderBy('id');
    }

    public function getOrdersWithItems(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['customer_id' => 'id'])->with('orderItems');
    }

    public function getExpensiveOrdersWithNullFK(): ActiveQuery
    {
        return $this->hasMany(OrderWithNullFK::class, ['customer_id' => 'id'])->andWhere('[[total]] > 50')->orderBy('id');
    }

    public function getOrdersWithNullFK(): ActiveQuery
    {
        return $this->hasMany(OrderWithNullFK::class, ['customer_id' => 'id'])->orderBy('id');
    }

    public function getOrders2(): ActiveQuery
    {
        return $this->hasMany(Order::class, ['customer_id' => 'id'])->inverseOf('customer2')->orderBy('id');
    }

    // deeply nested table relation
    public function getOrderItems(): ActiveQuery
    {
        /* @var $rel ActiveQuery */
        $rel = $this->hasMany(Item::class, ['id' => 'item_id']);

        return $rel->viaTable('order_item', ['order_id' => 'id'], function ($q) {
            /* @var $q ActiveQuery */
            $q->viaTable('order', ['customer_id' => 'id']);
        })->orderBy('id');
    }

    /**
     * @return CustomerQuery
     */
    public static function find(): CustomerQuery
    {
        return new CustomerQuery(static::class);
    }
}
