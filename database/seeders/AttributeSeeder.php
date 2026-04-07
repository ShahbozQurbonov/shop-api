<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['color', 'variant', 'size'] as $name) {
            Attribute::create(['name' => $name]);
        }
    }
}
