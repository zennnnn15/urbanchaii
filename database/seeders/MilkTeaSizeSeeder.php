<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MilkTeaSize;
class MilkTeaSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [
            ['name' => 'Small', 'price' => 3.50],
            ['name' => 'Medium', 'price' => 4.50],
            ['name' => 'Large', 'price' => 5.50],
        ];

        foreach ($sizes as $size) {
            MilkTeaSize::create($size);
        }
    }
}
