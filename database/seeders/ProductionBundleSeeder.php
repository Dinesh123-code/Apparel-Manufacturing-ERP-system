<?php

namespace Database\Seeders;

use App\Models\Buyer;
use App\Models\ProductionBundle;
use App\Models\SewingLine;
use App\Models\Style;
use Illuminate\Database\Seeder;

class ProductionBundleSeeder extends Seeder
{
    public function run(): void
    {
        $buyers  = Buyer::all();
        $lines   = SewingLine::all();
        $colors  = ['Navy Blue', 'Black', 'White', 'Red', 'Grey', 'Green', 'Yellow', 'Maroon', 'Beige', 'Pink'];
        $sizes   = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
        $operators = ['John Smith', 'Jane Doe', 'Ali Hassan', 'Maria Gomez', 'Wang Lei', 'Rahim Ahmed', 'Sunita Rao'];

        $total   = 1000; // seed 1000 records; adjust up to 50000 as needed
        $counter = 1;

        $this->command->info("Seeding {$total} production bundles...");

        for ($i = 0; $i < $total; $i++) {
            $buyer = $buyers->random();
            $style = Style::where('buyer_id', $buyer->id)->inRandomOrder()->first();
            if (!$style) continue;

            $line     = $lines->random();
            $quantity = rand(50, 500);
            $completed = rand(0, $quantity);
            $rejected  = rand(0, $quantity - $completed);

            ProductionBundle::create([
                'bundle_no'       => 'BND-' . str_pad($counter++, 6, '0', STR_PAD_LEFT),
                'buyer_id'        => $buyer->id,
                'style_id'        => $style->id,
                'color'           => $colors[array_rand($colors)],
                'size'            => $sizes[array_rand($sizes)],
                'line_id'         => $line->id,
                'quantity'        => $quantity,
                'completed_qty'   => $completed,
                'rejected_qty'    => $rejected,
                'operator_name'   => $operators[array_rand($operators)],
                'production_date' => now()->subDays(rand(0, 365))->format('Y-m-d'),
                'remarks'         => rand(0, 3) === 0 ? 'Batch ' . rand(1, 20) : null,
            ]);

            if ($i % 100 === 0) {
                $this->command->info("  {$i}/{$total} seeded...");
            }
        }

        $this->command->info("Done! {$total} bundles seeded.");
    }
}
