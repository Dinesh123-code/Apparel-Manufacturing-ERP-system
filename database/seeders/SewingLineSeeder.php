<?php

namespace Database\Seeders;

use App\Models\SewingLine;
use Illuminate\Database\Seeder;

class SewingLineSeeder extends Seeder
{
    public function run(): void
    {
        $lines = ['Line A', 'Line B', 'Line C', 'Line D', 'Line E', 'Line F', 'Line G', 'Line H'];

        foreach ($lines as $name) {
            SewingLine::firstOrCreate(['line_name' => $name]);
        }
    }
}
