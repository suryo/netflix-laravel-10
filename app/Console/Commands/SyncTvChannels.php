<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TvChannel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class SyncTvChannels extends Command
{
    protected $signature = 'tv:sync {--country= : ISO 3166-1 alpha-2 country code (e.g., ID)} {--limit=100 : Maximum channels to import}';
    protected $description = 'Synchronize TV channels with iptv-org data';

    public function handle()
    {
        $country = strtoupper($this->option('country'));
        $limit = (int) $this->option('limit');

        $this->info("Fetching channels from iptv-org...");
        
        // Fetch channels and streams in parallel if possible, but for simplicity we fetch sequentially
        $channelsResponse = Http::get('https://iptv-org.github.io/api/channels.json');
        $streamsResponse = Http::get('https://iptv-org.github.io/api/streams.json');

        if (!$channelsResponse->successful() || !$streamsResponse->successful()) {
            $this->error("Failed to fetch data from iptv-org API.");
            return 1;
        }

        $allChannels = collect($channelsResponse->json());
        $allStreams = collect($streamsResponse->json());

        $this->info("Total channels found: " . $allChannels->count());

        // Filter by country if provided
        if ($country) {
            $allChannels = $allChannels->filter(fn($c) => strtoupper($c['country'] ?? '') === $country);
            $this->info("Channels for {$country}: " . $allChannels->count());
        }

        // Limit processing
        $processChannels = $allChannels->take($limit);
        $this->info("Processing top {$processChannels->count()} channels...");

        $bar = $this->output->createProgressBar($processChannels->count());
        $bar->start();

        $count = 0;
        $blacklist = ['example.com', 'localhost', '127.0.0.1', 'test.com', 'domain.com'];

        foreach ($processChannels as $ch) {
            // Find working streams for this channel
            $streams = $allStreams->where('channel', $ch['id'])
                                 ->filter(fn($s) => !Str::contains($s['url'], $blacklist))
                                 ->sortByDesc(function ($s) {
                                     // Priority: HTTPS > HTTP, M3U8 > Others
                                     $score = 0;
                                     if (Str::startsWith($s['url'], 'https')) $score += 10;
                                     if (Str::endsWith($s['url'], '.m3u8')) $score += 5;
                                     return $score;
                                 });
            
            $stream = $streams->first();
            
            if (!$stream) {
                $bar->advance();
                continue;
            }

            // Validate the stream URL (not a placeholder)
            $host = parse_url($stream['url'], PHP_URL_HOST);
            if (in_array($host, $blacklist) || empty($stream['url'])) {
                $bar->advance();
                continue;
            }

            TvChannel::updateOrCreate(
                ['name' => $ch['name']],
                [
                    'slug' => Str::slug($ch['name']),
                    'category' => $ch['categories'][0] ?? 'General',
                    'stream_url' => $stream['url'],
                    'logo' => $ch['logo'] ?? null,
                    'description' => "Official stream for " . $ch['name'] . " from " . $ch['country'],
                    'country' => $ch['country'],
                    'is_active' => true,
                ]
            );

            $count++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully synchronized {$count} channels.");

        return 0;
    }
}
