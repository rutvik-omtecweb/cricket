<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'menu_name',
        'page_url',
        'parent_id',
        'order',
        'icon',
        'is_active',
        'created_by',
        'updated_by',
    ];

    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function active_children()
    {
        return $this->children()->where('is_active', true);
    }
}
