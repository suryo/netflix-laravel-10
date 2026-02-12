<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TvChannel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'country',
        'logo',
        'stream_url',
        'description',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($channel) {
            $channel->slug = Str::slug($channel->name);
        });
    }
}
