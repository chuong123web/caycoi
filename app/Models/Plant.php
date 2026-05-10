<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Plant extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'name_vi',
        'slug',
        'description',
        'price',
        'category',
        'light',
        'tag',
        'care_instructions',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Plant $plant) {
            if (empty($plant->slug)) {
                $plant->slug = Str::slug($plant->name);
            }
        });

        static::updating(function (Plant $plant) {
            if ($plant->isDirty('name') && !$plant->isDirty('slug')) {
                $plant->slug = Str::slug($plant->name);
            }
        });
    }

    /**
     * Get the route key name for implicit binding.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Register media collections for the plant.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useFallbackUrl('/images/placeholder-plant.jpg')
            ->useFallbackPath(public_path('/images/placeholder-plant.jpg'));

        $this->addMediaCollection('thumbnail')
            ->singleFile()
            ->useFallbackUrl('/images/placeholder-plant.jpg')
            ->useFallbackPath(public_path('/images/placeholder-plant.jpg'));
    }

    /**
     * Register media conversions.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(500)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('preview')
            ->width(800)
            ->height(1000)
            ->sharpen(10)
            ->nonQueued();
    }

    /**
     * Get the primary image URL.
     */
    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('thumbnail') ?: $this->getFirstMediaUrl('images');
    }

    /**
     * Get the thumbnail URL.
     */
    public function getThumbUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('thumbnail', 'thumb') ?: $this->getFirstMediaUrl('images', 'thumb');
    }

    /**
     * Formatted price in VND.
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.') . ' ₫';
    }

    /**
     * Scope for active plants.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
