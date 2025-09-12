<?php

declare(strict_types=1);

namespace ACTC\Results;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Result extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'result_category_id',
        'section',
        'division',
        'item',
        'position',
        'name',
        'points',
    ];

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ResultCategory::class);
    }
}
