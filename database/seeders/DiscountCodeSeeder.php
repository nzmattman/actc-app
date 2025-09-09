<?php

declare(strict_types=1);

namespace Database\Seeders;

use ACTC\Discounts\Discount;
use Illuminate\Database\Seeder;

class DiscountCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'expires_at' => now()->addYear(),
                'code' => 'abc123',
                'type' => 1,
                'weeks' => 1,
            ],
            [
                'expires_at' => now()->addYear(),
                'code' => 'def123',
                'type' => 2,
                'value' => 10000,
            ],
            [
                'expires_at' => now()->addYear(),
                'code' => 'ghi123',
                'type' => 3,
                'percent' => 50,
            ],
        ];

        foreach ($items as $item) {
            Discount::create($item);
        }
    }
}
