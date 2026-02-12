<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvChannel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TvChannelController extends Controller
{
    public function index()
    {
        $channels = TvChannel::latest()->paginate(15);
        return view('admin.tv_channels.index', compact('channels'));
    }

    public function create()
    {
        return view('admin.tv_channels.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:1024',
            'stream_url' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        $data['country'] = strtoupper($request->country);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('tv/logos', 'public');
        }

        TvChannel::create($data);
        return redirect()->route('admin.tv-channels.index')->with('success', 'Channel created successfully!');
    }

    public function edit(TvChannel $tvChannel)
    {
        return view('admin.tv_channels.edit', compact('tvChannel'));
    }

    public function update(Request $request, TvChannel $tvChannel)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'logo' => 'nullable|image|max:1024',
            'stream_url' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        $data['country'] = strtoupper($request->country);

        if ($request->hasFile('logo')) {
            if ($tvChannel->logo) Storage::disk('public')->delete($tvChannel->logo);
            $data['logo'] = $request->file('logo')->store('tv/logos', 'public');
        }

        $tvChannel->update($data);
        return redirect()->route('admin.tv-channels.index')->with('success', 'Channel updated successfully!');
    }

    public function destroy(TvChannel $tvChannel)
    {
        if ($tvChannel->logo) Storage::disk('public')->delete($tvChannel->logo);
        $tvChannel->delete();
        return redirect()->route('admin.tv-channels.index')->with('success', 'Channel deleted successfully!');
    }
}
