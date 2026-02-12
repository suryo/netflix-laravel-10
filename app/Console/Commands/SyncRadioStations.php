<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RadioStation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class SyncRadioStations extends Command
{
    protected $signature = 'radio:sync {--country=ID : ISO 3166-1 alpha-2 country code} {--limit=100 : Maximum stations to import}';
    protected $description = 'Synchronize radio stations with Radio Browser API';

    public function handle()
    {
        $countryCode = strtoupper($this->option('country'));
        $limit = (int) $this->option('limit');

        $this->info("Fetching radio stations for country: {$countryCode}...");
        
        // Fetch from radio-browser.info (using a random base server for better reliability)
        $response = Http::get("https://de1.api.radio-browser.info/json/stations/search", [
            'countrycode' => $countryCode,
            'limit' => $limit,
            'hidebroken' => 'true',
            'order' => 'clickcount',
            'reverse' => 'true'
        ]);

        if (!$response->successful()) {
            $this->error("Failed to fetch data from Radio Browser API.");
            return 1;
        }

        $stations = collect($response->json());
        $this->info("Total stations found: " . $stations->count());

        $bar = $this->output->createProgressBar($stations->count());
        $bar->start();

        $count = 0;
        foreach ($stations as $data) {
            try {
                // Validate stream URL
                if (empty($data['url_resolved']) && empty($data['url'])) {
                    $bar->advance();
                    continue;
                }

                // Clean city name
                $city = trim($data['state'] ?? 'Unknown City');
                if (Str::lower($city) === 'indonesia' || empty($city)) {
                    $city = 'Lainnya';
                }

                // Prioritize stable formats (MP3/AAC) and HTTPS
                $streamUrl = $data['url_resolved'] ?: $data['url'];
                $priorityScore = 0;
                if (Str::startsWith($streamUrl, 'https')) $priorityScore += 10;
                if (!Str::contains($streamUrl, '.m3u8')) $priorityScore += 5; // HLS is often problematic for pure audio tags
                
                $station = RadioStation::where('name', $data['name'])->first();
                
                RadioStation::updateOrCreate(
                    ['name' => $data['name']],
                    [
                        'slug' => $station ? $station->slug : Str::slug($data['name']) . '-' . Str::random(5),
                        'city' => $city,
                        'country' => $data['countrycode'],
                        'logo' => $data['favicon'] ?: null,
                        'stream_url' => $data['url_resolved'] ?: $data['url'],
                        'tags' => $data['tags'] ?: 'Radio',
                        'is_active' => true,
                    ]
                );
            } catch (\Exception $e) {
                $this->error("\nError syncing {$data['name']}: " . $e->getMessage());
            }

            $count++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully synchronized {$count} radio stations.");

        return 0;
    }
}
