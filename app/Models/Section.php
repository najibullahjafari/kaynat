<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'image',
        'icon',
        'order',
        'is_active'
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean'
    ];

    public function getTranslatedContent($language = null)
    {
        $language = $language ?? app()->getLocale();
        return $this->content[$language] ?? $this->content['en'] ?? '';
    }
}
