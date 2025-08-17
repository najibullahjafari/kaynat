<?php

namespace App\Services;

use App\Models\DynamicContent;

class DynamicContentService
{
    public function getContent($key, $lang = null, $default = null)
    {
        $lang = $lang ?? app()->getLocale();
        $content = DynamicContent::where('key', $key)->first();

        if (!$content) {
            return $default;
        }

        return $content->content[$lang] ?? $default;
    }

    public function getImage($key)
    {
        $content = DynamicContent::where('key', $key)->first();
        return $content->image ?? null;
    }
}
