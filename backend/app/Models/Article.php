<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'content', 'url', 'source', 'category', 'author', 'published_at', 'image_url'
    ];

    // Scope for filtering
    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['keyword'])) {
            $query->where('title', 'like', '%'.$filters['keyword'].'%')
                  ->orWhere('content', 'like', '%'.$filters['keyword'].'%');
        }

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (!empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }

        if (!empty($filters['date'])) {
            $query->where('published_at', $filters['date']);
        }

        return $query->latest('id');
    }
}
