<?php

namespace Database\Seeders;

use App\Models\Admin\Box;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 30 ; $i++) {
            Box::create([
                'name' => 'PLATINO',
                'identifier' => $i
            ]);
        }
        for ($i=1; $i <= 34 ; $i++) {
            Box::create([
                'name' => 'ORO',
                'identifier' => $i
            ]);
        }
    }
}
