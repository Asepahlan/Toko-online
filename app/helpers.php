<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;

if (!function_exists('default_image')) {
    function default_image($type) {
        return asset(config('constants.default_images.' . $type));
    }
}

if (!function_exists('category_image')) {
    function category_image($category) {
        $path = 'images/categories/' . $category->slug . '.png';
        $fullPath = public_path($path);

        if (File::exists($fullPath)) {
            $timestamp = File::lastModified($fullPath);
            return asset($path) . '?v=' . $timestamp;
        }

        return default_image('category');
    }
}
