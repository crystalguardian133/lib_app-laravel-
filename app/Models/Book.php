<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'uuid', 'title', 'author', 'genre', 'published_year', 'availability', 'qr_url', 'cover_image', 'genres'
    ];

    protected $casts = [
        'genres' => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Book $book) {
            if (empty($book->uuid)) {
                $book->uuid = (string) Str::uuid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    /**
     * Get genres as an array, always.
     * If genres is set, use it. Otherwise, split legacy genre string.
     */
    public function getGenresListAttribute()
    {
        if (is_array($this->genres) && !empty($this->genres)) {
            return collect($this->genres)
                ->flatMap(function ($item) {
                    if (!is_string($item)) {
                        return [];
                    }
                    return preg_split('/\s*[,\/&;|\\\\]+\s*/', $item) ?: [];
                })
                ->map(fn ($g) => trim($g))
                ->filter(fn ($g) => $g !== '')
                ->unique()
                ->values()
                ->all();
        }
        if (!empty($this->genre)) {
            // Split by common separators (comma, slash, ampersand, semicolon, pipe, backslash)
            return collect(preg_split('/\s*[,\/&;|\\\\]+\s*/', $this->genre) ?: [])
                ->map(fn ($g) => trim($g))
                ->filter(fn ($g) => $g !== '')
                ->values()
                ->all();
        }
        return [];
    }
}

