<?php

namespace App\Http\Controllers;

use App\Models\TvChannel;
use Illuminate\Http\Request;

class TvController extends Controller
{
    public function index(Request $request)
    {
        $selectedCountry = $request->get('country');
        
        if ($selectedCountry) {
            $channels = TvChannel::where('is_active', true)
                                ->where('country', strtoupper($selectedCountry))
                                ->latest()->get();
            return response()->json($channels);
        }

        // Get countries that have active channels, along with counts
        $countries = TvChannel::where('is_active', true)
                            ->whereNotNull('country')
                            ->select('country', \DB::raw('count(*) as total'))
                            ->groupBy('country')
                            ->get()
                            ->mapWithKeys(function ($item) {
                                return [$item->country => $item->total];
                            });

        return view('tv.index', compact('countries'));
    }

    public function show($slug)
    {
        $channel = TvChannel::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $channels = TvChannel::where('is_active', true)->where('id', '!=', $channel->id)->get();
        return view('tv.show', compact('channel', 'channels'));
    }
}
