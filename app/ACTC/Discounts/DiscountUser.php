<?php

declare(strict_types=1);

namespace ACTC\Discounts;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $discount_id
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountUser query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountUser whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscountUser whereUserId($value)
 * @mixin \Eloquent
 */
class DiscountUser extends Model
{
    protected $table = 'discount_user';

    protected $fillable = [
        'discount_id',
        'user_id',
    ];
}
