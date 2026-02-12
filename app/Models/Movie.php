<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'poster',
        'backdrop',
        'video_url',
        'is_featured',
        'is_slider',
        'rating',
        'release_year',
        'duration',
        'director',
        'cast',
        'category_id',
        'quality',
        'type',
        'views',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($movie) {
            $movie->slug = Str::slug($movie->title);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class)->orderBy('episode_number', 'asc');
    }

    /**
     * Get Google Drive embed URL from the video_url
     */
    public function getEmbedUrlAttribute()
    {
        $url = $this->video_url;
        if (!$url) return null;

        // Extract Google Drive File ID from various URL formats
        $patterns = [
            '/\/file\/d\/([a-zA-Z0-9_-]+)/',       // /file/d/FILE_ID/
            '/id=([a-zA-Z0-9_-]+)/',                // id=FILE_ID
            '/\/d\/([a-zA-Z0-9_-]+)/',              // /d/FILE_ID
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return 'https://drive.google.com/file/d/' . $matches[1] . '/preview';
            }
        }

        // If it's already an embed/preview URL or non-gdrive URL, return as-is
        return $url;
    }
}
