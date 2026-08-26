<?php

namespace Database\Seeders;

use App\Models\Buyer;
use App\Models\Style;
use Illuminate\Database\Seeder;

class StyleSeeder extends Seeder
{
    public function run(): void
    {
        $buyers = Buyer::all();
        $types  = ['T-Shirt', 'Polo', 'Jacket', 'Shorts', 'Denim', 'Dress', 'Blouse', 'Pants', 'Hoodie', 'Vest'];

        foreach ($buyers as $buyer) {
            foreach ($types as $i => $type) {
                Style::firstOrCreate([
                    'buyer_id' => $buyer->id,
                    'style_no' => strtoupper(substr(str_replace(['&', ' '], '', $buyer->buyer_name), 0, 3)) . '-' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                ]);
            }
        }
    }
}
