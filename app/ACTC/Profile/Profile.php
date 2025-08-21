<?php

declare(strict_types=1);

namespace ACTC\Profile;

use ACTC\Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasUuid;
    use SoftDeletes;

    protected $fillable = [
        'uuid',
    ];
}
