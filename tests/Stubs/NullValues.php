<?php

declare(strict_types=1);

namespace Yiisoft\ActiveRecord\Tests\Stubs;

/**
 * Class NullValues.
 *
 * @property int $id
 * @property int $var1
 * @property int $var2
 * @property int $var3
 * @property string $stringcol
 */
class NullValues extends ActiveRecord
{
    public static function tableName(): string
    {
        return 'null_values';
    }
}
