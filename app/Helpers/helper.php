<?php

use App\Models\TranslationLanguage;
use Spatie\Permission\Models\Role;

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

if (!function_exists('userRole')) {
    /**
     * Get all roles for dropdown select.
     *
     * @param bool $flip
     * @return array
     */
    function userRole(bool $flip = false)
    {
        $roles = Role::all()->toArray();

        return $flip ? array_flip($roles) : $roles;
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
        $def_lang = TranslationLanguage::where('slug', app()->getLocale())->first();
        return $def_lang ? $def_lang : null;
    }
}
if (!function_exists('datatable_lang')) {
    function datatable_lang(array $override = [])
    {
        $langs = [
            "search"            => "",
            "lengthMenu"        => "_MENU_",
            "searchPlaceholder" => trans('general.search'),
            'emptyTable'        => trans('core::table.empty-table'),
            "processing"        => '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            'sZeroRecords'      => trans('table.zero-record'),
            'paginate'          => [
                'next'     => trans('general.next'),
                'previous' => trans('general.previous'),
            ],
        ];
        return $override ? array_replace($langs, $override) : $langs;
    }
}
