<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'name',
        'email',
        'whatsapp',
        'content',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
