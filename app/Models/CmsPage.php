<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CmsPage extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'cms_page_name',
        'body',
        'url',
        'meta_title',
        'meta_tag',
        'meta_tag_keyword',
        'meta_description',
        'is_active',
        'is_show',
        'slug'
    ];

    protected $casts = [
        'is_active' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
