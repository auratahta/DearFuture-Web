<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class News extends Model
{
    use HasFactory, SoftDeletes;

    // Nama tabel di database
    protected $table = 'news';

    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'title',
        'category', 
        'excerpt',
        'content',
        'image',
        'status',
        'publish_date',
        'author_id',
        'featured',
        'tags',
        'views'
    ];

    // Casting tipe data
    protected $casts = [
        'publish_date' => 'datetime',
        'featured' => 'boolean',
        'views' => 'integer',
        'tags' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    // Tambahan attribute yang akan ditampilkan
    protected $appends = [
        'image_url', 
        'formatted_publish_date', 
        'category_label', 
        'status_label',
        'tags_as_string'
    ];

    // Event saat model dibuat
    protected static function boot()
    {
        parent::boot();

        // Log saat akan membuat news baru
        static::creating(function ($model) {
            \Log::info('Creating News:', [
                'title' => $model->title,
                'author_id' => $model->author_id
            ]);
        });

        // Log saat berhasil membuat news
        static::created(function ($model) {
            \Log::info('News Created Successfully:', [
                'id' => $model->id,
                'title' => $model->title
            ]);
        });
    }

    // Relasi ke User (Author)
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // Scope untuk news yang published
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where('publish_date', '<=', now());
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByCategory($query, $category)
    {
        if ($category && $category !== 'all') {
            return $query->where('category', $category);
        }
        return $query;
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    // Scope untuk news yang featured
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Scope untuk search
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }
        return $query;
    }

    // Accessor untuk URL gambar
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-news.jpg');
    }

    // Accessor untuk format tanggal
    public function getFormattedPublishDateAttribute()
    {
        return $this->publish_date ? $this->publish_date->format('M j, Y') : '';
    }

    // Accessor untuk label kategori
    public function getCategoryLabelAttribute()
    {
        return strtoupper($this->category);
    }

    // Accessor untuk label status
    public function getStatusLabelAttribute()
    {
        return ucfirst($this->status);
    }

    // Accessor untuk tags sebagai string
    public function getTagsAsStringAttribute()
    {
        if ($this->tags && is_array($this->tags)) {
            return implode(', ', $this->tags);
        }
        return '';
    }

    // Mutator untuk mengubah tags string menjadi array
    public function setTagsAttribute($value)
    {
        if (is_string($value) && !empty(trim($value))) {
            // Pisahkan dengan koma dan bersihkan
            $tags = array_map('trim', explode(',', $value));
            $tags = array_filter($tags); // Hapus tag kosong
            $this->attributes['tags'] = json_encode(array_values($tags));
        } elseif (is_array($value)) {
            $this->attributes['tags'] = json_encode($value);
        } else {
            $this->attributes['tags'] = null;
        }
    }

    // Method untuk menambah views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Method untuk cek apakah published
    public function isPublished()
    {
        return $this->status === 'published' && $this->publish_date <= now();
    }
}