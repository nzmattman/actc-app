<?php

declare(strict_types=1);

namespace ACTC\Results;

use ACTC\Core\Traits\HasActive;
use ACTC\Core\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\EloquentSortable\SortableTrait;

class ResultCategory extends Model
{
    use HasActive;
    use HasUuid;
    use SoftDeletes;
    use SortableTrait;

    protected $fillable = [
        'uuid',
        'active',
        'position',
        'start_at',
        'end_at',
        'name',
        'state_id',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ];
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
