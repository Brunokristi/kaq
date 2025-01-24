<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Basic', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Contacts', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finances', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Calendar', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meetings', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Maps', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sharing', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Barcodes', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

