<?php

declare(strict_types=1);

namespace Database\Seeders;

use ACTC\Core\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            'NSW' => 'New South Wales',
            'VIC' => 'Victoria',
            'QLD' => 'Queensland',
            'WA' => 'Western Australia',
            'SA' => 'South Australia',
            'TAS' => 'Tasmania',
            'ACT' => 'Australian Capital Territory',
            'NT' => 'Northern Territory',
        ];

        foreach ($states as $code => $name) {
            State::create([
                'code' => $code,
                'name' => $name,
            ]);
        }
    }
}
