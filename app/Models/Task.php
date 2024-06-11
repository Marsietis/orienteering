<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'points',
        'image_path',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }
}
