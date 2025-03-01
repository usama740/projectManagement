<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            ['name' => 'department', 'type' => 'text', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'start_date', 'type' => 'date', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'end_date', 'type' => 'date', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('attributes')->insert($attributes);
    }
}
