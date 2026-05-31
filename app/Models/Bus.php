<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bus extends Model
{
    protected $fillable = ['plate_number', 'capacity', 'image_path', 'description'];

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function getImageUrlAttribute(): string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return '';
    }
}
