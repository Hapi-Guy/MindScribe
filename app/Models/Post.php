<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasSlug;

    protected $fillable = [
        // 'image',
        'title',
        'slug',
        'content',
        'cover_image',
        'category_id',
        'user_id',
        'published_at',
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->width(400);

        $this
            ->addMediaConversion('large')
            ->width(1200);
    }
    
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->singleFile();
    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function claps()
    {
        return $this->hasMany(Clap::class);
    }

    public function readTime($wordsPerMinute = 100)
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / $wordsPerMinute);

        return max(1, $minutes);
    }
    
    public function imageUrl($conversionName = '')
    {
        $media = $this->getFirstMedia();
        if (!$media) {
            return null;
        }
        if ($media->hasGeneratedConversion($conversionName)) {
            return $media->getUrl($conversionName);
        }
        return $media->getUrl();
    }

    /**
     * Resolve a displayable URL for the cover image, always falling back to a
     * local default so a null/blank cover_image never renders a broken <img>.
     */
    public function coverImageUrl(): string
    {
        $cover = $this->cover_image;

        if (blank($cover)) {
            return asset('images/default-cover.svg');
        }

        // Unsplash (or any remote) URL saved at creation time.
        if (Str::startsWith($cover, ['http://', 'https://'])) {
            return $cover;
        }

        // File uploaded to the 'covers' folder on the public disk.
        if (Str::startsWith($cover, 'covers/')) {
            return Storage::disk('public')->url($cover);
        }

        // Local default image path (e.g. images/default-cover.svg).
        return asset($cover);
    }
}
