<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;
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

        // Clear frontend cache whenever plant data changes
        static::saved(function () {
            Cache::forget('global_plants');
        });

        static::deleted(function () {
            Cache::forget('global_plants');
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
        $this->addMediaCollection('images');

        $this->addMediaCollection('thumbnail')
            ->singleFile();
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
        // Priority 1: Return Spatie media URL if media exists in database
        $media = $this->getFirstMedia('thumbnail') ?: $this->getFirstMedia('images');
        
        if ($media) {
            // Check if physical file still exists (Railway ephemeral storage)
            try {
                if (file_exists($media->getPath())) {
                    return url($media->getUrl());
                }
            } catch (\Throwable $e) {
                // Fall through to fallback
            }
        }
        
        // Priority 2: Fallback to pre-defined external images
        $fallbackImages = [
            'monstera-deliciosa' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAEal89Ri29QIEUyt8Q5hnSJIN8m1dYff6pRCkj676kk0GoS7sgZj7f7-_8d06cwQ8ulynVHu1h6pzv48LKVbNb-_kQ-V6408tW4lOyYlzZMrJzYWRCiaInFpZpD6glvEVr3ZFQ_cKMiH3IAvk3loYlwL9iHQnIcxzuK1h6Acwbdd1qZRYY48OMF6Pz-mgXAmlk9gZHAXqMke9X8uD-mKHer6xWXwP3hHJ39bPOXWLZMAH1M-Knp5eUAF3panSDr2sLrVT7tMVJY61V',
            'zz-plant' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAnzfmbsjoknHW7FwQmr9s8-YLNuNKa2a43l68Q7g_k4RLKX2qfGnmyhA_GI-rQCixBw_DAodkfZJvH_XCkIezu46nd3STrsT2LiqPEwCN1hBldWg61IOdzNcMT9dmvlgkuPY434qmkmqETTOO0q3uzmo0EEItk9Jc7RqzoPwTRLNF7rC1YsiF9vVTwUDsc-jyfKL2DLZL_piPudMtF_U-fLVT3Vqf5qC8miG7H7TMmkGBpFxmwmj2Ltgoh7dPY4czN5MA0FaAons6x',
            'ficus-lyrata' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC4Zh-MdixM4lWccvocDjlZcG0rL4wt9rnaB6k6nw5cUneYNN3Kdxd5QLj73n_7ppQNfClMGuqwOJgtyzjant5jvQahKUYgLyvZ-4PFMqDKNN01EaRhD87d4i17Kr9epJmfMBW2lkq1amjWGCXAHL_DtOyGyWvnVN9YksE-ygbF6pF3qdCDiYQbNotG6SaYbPW6U-aoIeLJKkEZrh2hxocpU39IpnQIleVM4Mpm4aZKeTN_q9TCyB75cLK6F5YasURH05VOTkyljzm3',
            'sansevieria' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCB-n1pkzPhtKq0oelu7ZehDrQFiQnF3_4sqBFeUc_b7Ye7ecbfiDjne1Oj6DsdalQETKlx6PL57iO6pde07Sx1XeDR9JNTdWcItoay_a4k07yoJpEXq7dlU93dsLDrdIQQav-ckxTmV-NngozoFg6ae0Qxao5v6YqXIcq1lK2OAueNoJGv5LemLn9p_O136KSQWlXoDbWSnITCcFkvPezsd0KkuBOL3L2D1o7Qb7LmLgFmmuqDgfM7v2tmYxKFUPlMv7EyX6R-89V2',
            'spathiphyllum' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD4vKsStOncCVes8E0X0XJV6kZquhhD0dAfUGPOAH_Ty4VrZ7OVll8lLP8bdjuD3rIwtmKWeaqfU79DtnAZlkHVANG9Ncm3XOgQKujPGEqOx2TqEVhe21mgAvo540bSIiCe-_Z_yCwfG2A2xXNT7UqupmUw6kUqb1ZkLBhCde2ji75CCBvah8u1wigKfODnmaMkXqQuOv705p_EUEBZl3rh6gyYBR8PPM3v10BInt8NR2W5UtWSihLdI3Gi9pbEKKGfgmNZB-_TGl4-',
            'pothos-golden' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC_MGti7UvKFiwM302cJKpJh_GCN0DBHWJFqgZN-E8zmxZmSz3vnO2RRiyX7kxTMt4jUCn8VbnjC_bvPgBEyVndP5x6u3RI4_5UhlWGfO1oO-hyWPKsLnr3iCxWhoYAyxfPXYBWos3C2dLeO2CpCbe7xjETm2mhzJw6vKSyqvrawzPnMQ3_e9Q3F-cE_8ch_OGXlcvwe0VCCcKOYCKikk5h8t1r7apjeZrW7pkcoyg6-SFuUFbg9YBYYUuZy30Yx1nmLsp0bLBBdPV1',
            'string-of-pearls' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCisZZlhb_te2FqNmi_CTghkaOx8IdWqsVz04QahYffNfIUEuvLAdyphKoV2k2mB3iaQmLe4EnI7ff77qSLKNccvWsBkvcIpqSanRi6AOZ_bDyimsg-YXi64Iyqd3lvAVp-JNBSO5zRTo2XDPLmzSspXTcJrIcAx3GOmKJ2XpE9FE2UeMClcNBDkcnA8muHCLw6fog8js-t89QK2km2oS8IbzSDzXEqUvTJKJzO5WuSgoRQOFVOu2hIlyrc99rvkPiWpDOoPGNQG0sQ',
            'calathea-orbifolia' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC4Zh-MdixM4lWccvocDjlZcG0rL4wt9rnaB6k6nw5cUneYNN3Kdxd5QLj73n_7ppQNfClMGuqwOJgtyzjant5jvQahKUYgLyvZ-4PFMqDKNN01EaRhD87d4i17Kr9epJmfMBW2lkq1amjWGCXAHL_DtOyGyWvnVN9YksE-ygbF6pF3qdCDiYQbNotG6SaYbPW6U-aoIeLJKkEZrh2hxocpU39IpnQIleVM4Mpm4aZKeTN_q9TCyB75cLK6F5YasURH05VOTkyljzm3',
            'philodendron-pink-princess' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAEal89Ri29QIEUyt8Q5hnSJIN8m1dYff6pRCkj676kk0GoS7sgZj7f7-_8d06cwQ8ulynVHu1h6pzv48LKVbNb-_kQ-V6408tW4lOyYlzZMrJzYWRCiaInFpZpD6glvEVr3ZFQ_cKMiH3IAvk3loYlwL9iHQnIcxzuK1h6Acwbdd1qZRYY48OMF6Pz-mgXAmlk9gZHAXqMke9X8uD-mKHer6xWXwP3hHJ39bPOXWLZMAH1M-Knp5eUAF3panSDr2sLrVT7tMVJY61V',
            'alocasia-polly' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAnzfmbsjoknHW7FwQmr9s8-YLNuNKa2a43l68Q7g_k4RLKX2qfGnmyhA_GI-rQCixBw_DAodkfZJvH_XCkIezu46nd3STrsT2LiqPEwCN1hBldWg61IOdzNcMT9dmvlgkuPY434qmkmqETTOO0q3uzmo0EEItk9Jc7RqzoPwTRLNF7rC1YsiF9vVTwUDsc-jyfKL2DLZL_piPudMtF_U-fLVT3Vqf5qC8miG7H7TMmkGBpFxmwmj2Ltgoh7dPY4czN5MA0FaAons6x',
        ];
        return $fallbackImages[$this->slug] ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuC4Zh-MdixM4lWccvocDjlZcG0rL4wt9rnaB6k6nw5cUneYNN3Kdxd5QLj73n_7ppQNfClMGuqwOJgtyzjant5jvQahKUYgLyvZ-4PFMqDKNN01EaRhD87d4i17Kr9epJmfMBW2lkq1amjWGCXAHL_DtOyGyWvnVN9YksE-ygbF6pF3qdCDiYQbNotG6SaYbPW6U-aoIeLJKkEZrh2hxocpU39IpnQIleVM4Mpm4aZKeTN_q9TCyB75cLK6F5YasURH05VOTkyljzm3';
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
