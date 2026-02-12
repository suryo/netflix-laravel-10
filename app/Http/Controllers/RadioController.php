<?php

namespace App\Http\Controllers;

use App\Models\RadioStation;
use Illuminate\Http\Request;

class RadioController extends Controller
{
    public function index(Request $request)
    {
        $selectedCity = $request->get('city');

        if ($selectedCity) {
            $stations = RadioStation::where('is_active', true)
                                  ->where('city', $selectedCity)
                                  ->latest()
                                  ->get();
            return response()->json($stations);
        }

        // Get cities that have active radio stations, along with counts
        $cities = RadioStation::where('is_active', true)
                            ->whereNotNull('city')
                            ->select('city', \DB::raw('count(*) as total'))
                            ->groupBy('city')
                            ->get()
                            ->mapWithKeys(function ($item) {
                                return [$item->city => $item->total];
                            })
                            ->toArray();

        // Sort cities alphabetically
        ksort($cities);

        return view('radio.index', compact('cities'));
    }

    public function show($slug)
    {
        $station = RadioStation::where('slug', $slug)
                             ->where('is_active', true)
                             ->firstOrFail();

        // Get other stations from the same city
        $otherStations = RadioStation::where('city', $station->city)
                                   ->where('id', '!=', $station->id)
                                   ->where('is_active', true)
                                   ->limit(10)
                                   ->get();

        return view('radio.show', compact('station', 'otherStations'));
    }
}
