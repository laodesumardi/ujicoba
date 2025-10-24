<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Helpers\StorageHelper;
use App\Events\ModelUpdated;

class News extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'category',
        'type',
        'status',
        'is_featured',
        'is_pinned',
        'views',
        'published_at',
        'author_name',
        'author_email',
        'tags',
        'meta_data'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_pinned' => 'boolean',
        'published_at' => 'datetime',
        'tags' => 'array',
        'meta_data' => 'array'
    ];

    /**
     * The event map for the model.
     */
    protected $dispatchesEvents = [
        'updated' => ModelUpdated::class,
        'created' => ModelUpdated::class,
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($news) {
            if (empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });

        static::updating(function ($news) {
            if ($news->isDirty('title') && empty($news->slug)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where(function($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                    });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // Accessors
    public function getFeaturedImageUrlAttribute()
    {
        if (!$this->featured_image) {
            return asset('images/default-news.png');
        }
        
        if (filter_var($this->featured_image, FILTER_VALIDATE_URL)) {
            return $this->featured_image;
        }
        
        if (str_starts_with($this->featured_image, 'http://') || str_starts_with($this->featured_image, 'https://')) {
            return $this->featured_image;
        }
        
        // Use direct image serving route with cache-busting
        $version = $this->updated_at ? $this->updated_at->timestamp : time();
        return route('image.serve.model', [
            'model' => 'news',
            'id' => $this->id,
            'field' => 'featured_image',
            'v' => $version,
        ]);
    }

    public function getExcerptAttribute($value)
    {
        if (empty($value) && $this->content) {
            return Str::limit(strip_tags($this->content), 150);
        }
        return $value;
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words per minute
        return $minutes . ' menit';
    }

    // Methods
    public function incrementViews()
    {
        $this->increment('views');
    }

    public function isPublished()
    {
        return $this->status === 'published' && 
               ($this->published_at === null || $this->published_at <= now());
    }

    public function getCategoryLabel()
    {
        $categories = [
            'akademik' => 'Akademik',
            'ekstrakurikuler' => 'Ekstrakurikuler',
            'libur' => 'Libur Nasional',
            'jadwal' => 'Perubahan Jadwal',
            'osis' => 'Kegiatan OSIS',
            'lomba' => 'Lomba & Kompetisi'
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    public function getTypeLabel()
    {
        return $this->type === 'news' ? 'Berita' : 'Pengumuman';
    }

    public function getStatusLabel()
    {
        $statuses = [
            'draft' => 'Draft',
            'published' => 'Dipublikasikan',
            'archived' => 'Diarsipkan'
        ];

        return $statuses[$this->status] ?? ucfirst($this->status);
    }
}
