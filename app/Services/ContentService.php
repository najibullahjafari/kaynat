<?php

namespace App\Services;

use App\Models\DynamicContent;
use App\Models\Section;
use App\Models\Solution;
use App\Models\Feature;
use App\Models\TechnologyItem;
use App\Models\IndustryCategory;
use App\Models\Testimonial;
use App\Models\TeamMember;

class ContentService
{
    public function getContent($key, $lang = null, $default = null)
    {
        $lang = $lang ?? app()->getLocale();
        $content = DynamicContent::where('key', $key)->first();

        if (!$content) {
            return $default;
        }

        return $content->getTranslatedContent($lang) ?? $default;
    }

    public function getSection($slug, $lang = null)
    {
        $lang = $lang ?? app()->getLocale();
        return Section::where('slug', $slug)->first();
    }

    public function getSolutions($limit = null, $featured = false)
    {
        $query = Solution::where('is_active', true)
            ->orderBy('order');

        if ($featured) {
            $query->where('is_featured', true);
        }

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }

    public function getFeatures()
    {
        return Feature::where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    public function getTechnologyItems($type = null)
    {
        $query = TechnologyItem::where('is_active', true);

        if ($type) {
            $query->where('type', $type);
        }

        return $query->get();
    }

    public function getIndustryCategories()
    {
        return IndustryCategory::where('is_active', true)->get();
    }

    public function getTestimonials($featured = false, $limit = null)
    {
        $query = Testimonial::where('is_active', true);

        if ($featured) {
            $query->where('is_featured', true);
        }

        if ($limit) {
            $query->take($limit);
        }

        return $query->get();
    }

    public function getTeamMembers()
    {
        return TeamMember::where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}
