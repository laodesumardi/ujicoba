<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'category',
        'type',
        'status',
        'is_featured',
        'download_count',
        'published_at',
        'expires_at',
        'tags',
        'metadata'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'tags' => 'array',
        'metadata' => 'array'
    ];

    // Auto-generate slug
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($document) {
            if (empty($document->slug)) {
                $document->slug = Str::slug($document->title);
            }
        });
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                      ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeRecent($query, $limit = 10)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    // Accessors
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    public function getFileSizeFormattedAttribute()
    {
        if (!$this->file_size) return null;
        
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getCategoryLabelAttribute()
    {
        $categories = [
            'surat_edaran' => 'Surat Edaran',
            'formulir' => 'Formulir',
            'pedoman' => 'Pedoman Akademik',
            'jadwal' => 'Jadwal',
            'kurikulum' => 'Kurikulum & Silabus',
            'laporan' => 'Laporan',
            'lainnya' => 'Lainnya'
        ];
        
        return $categories[$this->category] ?? ucfirst($this->category);
    }

    public function getTypeLabelAttribute()
    {
        $types = [
            'pdf' => 'PDF',
            'doc' => 'Word Document',
            'docx' => 'Word Document',
            'xls' => 'Excel Spreadsheet',
            'xlsx' => 'Excel Spreadsheet',
            'ppt' => 'PowerPoint',
            'pptx' => 'PowerPoint',
            'image' => 'Image',
            'other' => 'Other'
        ];
        
        return $types[$this->type] ?? ucfirst($this->type);
    }

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived'
        ];
        
        return $statuses[$this->status] ?? ucfirst($this->status);
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at < now();
    }

    public function getIsPublishedAttribute()
    {
        return $this->status === 'published' && 
               $this->published_at && 
               $this->published_at <= now() &&
               !$this->is_expired;
    }

    // Methods
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }

    public static function getCategories()
    {
        return [
            'surat_edaran' => 'Surat Edaran',
            'formulir' => 'Formulir',
            'pedoman' => 'Pedoman Akademik',
            'jadwal' => 'Jadwal',
            'kurikulum' => 'Kurikulum & Silabus',
            'laporan' => 'Laporan',
            'lainnya' => 'Lainnya'
        ];
    }

    public static function getTypes()
    {
        return [
            'pdf' => 'PDF',
            'doc' => 'Word Document',
            'docx' => 'Word Document',
            'xls' => 'Excel Spreadsheet',
            'xlsx' => 'Excel Spreadsheet',
            'ppt' => 'PowerPoint',
            'pptx' => 'PowerPoint',
            'image' => 'Image',
            'other' => 'Other'
        ];
    }
}
