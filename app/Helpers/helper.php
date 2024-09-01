<?php

use App\Models\TranslationLanguage;

if (!function_exists('mergePermission')) {
    function mergePermission($userPermissions, $allPermissions)
    {
        $allPermissions = $allPermissions->map(function ($perm) use ($userPermissions) {
            $perm->status = $userPermissions->contains('name', $perm->name);
            return $perm;
        });
        return $allPermissions->groupBy(function ($data) {
            return explode('.', $data->name)[0];
        });
    }
}

if (!function_exists('default_language')) {
    function default_language()
    {
        $def_lang = TranslationLanguage::defaultLanguage()->first();
        return $def_lang ? $def_lang->slug : null;
    }
}

if (!function_exists('getLanguage')) {
    function getLanguage()
    {
        $def_lang = TranslationLanguage::where('slug',app()->getLocale())->first();
        return $def_lang ? $def_lang : null;
    }
}
