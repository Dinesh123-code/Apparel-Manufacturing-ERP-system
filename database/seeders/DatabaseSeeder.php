<?php

namespace Database\Seeders;

use App\Models\Buyer;
use App\Models\SewingLine;
use App\Models\Style;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@bundle-erp.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
            ]
        );

        $this->call([
            BuyerSeeder::class,
            SewingLineSeeder::class,
            StyleSeeder::class,
            ProductionBundleSeeder::class,
        ]);
    }
}
