<?php

namespace Database\Seeders;

use App\Models\Buyer;
use Illuminate\Database\Seeder;

class BuyerSeeder extends Seeder
{
    public function run(): void
    {
        $buyers = [
            'H&M', 'Zara', 'Gap Inc.', 'Nike', 'Adidas',
            'Primark', 'Next PLC', 'Marks & Spencer', 'ASOS', 'Target Corp',
        ];

        foreach ($buyers as $name) {
            Buyer::firstOrCreate(['buyer_name' => $name]);
        }
    }
}
