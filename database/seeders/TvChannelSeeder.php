<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class TvChannelSeeder extends Seeder
{
    public function run(): void
    {
        // Curated set of countries to sync during seeding
        $countries = ['ID', 'US', 'GB', 'JP'];
        
        foreach ($countries as $country) {
            $this->command->info("Syncing TV channels for: {$country}...");
            Artisan::call('tv:sync', [
                '--country' => $country,
                '--limit' => 50
            ]);
        }
    }
}
