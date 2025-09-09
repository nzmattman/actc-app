<?php

declare(strict_types=1);

namespace ACTC\Discounts;

use Illuminate\Database\Eloquent\Model;

class DiscountUser extends Model
{
    protected $table = 'discount_user';

    protected $fillable = [
        'discount_id',
        'user_id',
    ];
}
