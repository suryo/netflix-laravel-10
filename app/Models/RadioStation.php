<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioStation extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'city',
        'country',
        'logo',
        'stream_url',
        'tags',
        'is_active',
    ];
    use HasFactory;
}
