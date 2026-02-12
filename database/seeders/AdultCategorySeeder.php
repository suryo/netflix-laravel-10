<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdultCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adultCategories = ['West', 'Indo', 'Hentai'];

        foreach ($adultCategories as $name) {
            Category::updateOrCreate(
                ['name' => $name],
                [
                    'slug' => Str::slug($name),
                    'is_adult' => true
                ]
            );
        }
    }
}
