<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

class Helper
{
    private const SYS_ADMIN = 'SYS_ADMIN';

    public static function getDataFiles($object, $fieldName = 'logo', $multiple = true)
    {
        if (empty($object['file_uris'][$fieldName])) {
            return '';
        }
        if ($multiple === true) {
            return array_values($object['file_uris'][$fieldName]);
        }
        return Arr::first($object['file_uris'][$fieldName]);
    }

    public static function urlToRoute($url): ?string
    {
        return app('router')->getRoutes()->match(app('request')->create($url))->getName();
    }

    public static function isShowItemMenu($menuObj)
    {
        if (auth()->user()->code === self::SYS_ADMIN) {
            return true;
        }
        return count(array_intersect(self::getAllChild($menuObj), session()->get('userGroup')['permissions'])) > 0;
    }

    private static function getAllChild($menuObj)
    {
        $permissions[] = $menuObj['permission'] ?? '';
        if (!empty($menuObj['child'])) {
            $permissions = array_merge($permissions, Arr::pluck($menuObj['child'], 'permission'));
            foreach ($menuObj['child'] as $menuChild) {
                if (!empty($menuChild['child'])) {
                    $permissions = array_merge($permissions, Arr::pluck($menuChild['child'], 'permission'));
                }
            }
        }
        return $permissions;
    }

    public static function isShowBlock($menuBlock)
    {
        $permissions = [];
        if (!empty($menuBlock['items'])) {
            foreach ($menuBlock['items'] as $item) {
                $permissions = array_merge($permissions, self::getAllChild($item));
            }
        }
        if (auth()->user()->code === self::SYS_ADMIN) {
            return true;
        }
        return count(array_intersect($permissions, session()->get('userGroup')['permissions'])) > 0;
    }

    public static function hasPermission($permissionName)
    {
        if (empty($permissionName) || empty(session()->get('userGroup')['permissions'])) {
            return false;
        }
        return in_array($permissionName, session()->get('userGroup')['permissions']);
    }

    public static function hasPermissionSubs($permissionName)
    {
        if (empty($permissionName) || empty(session()->get('userGroup')['permissions'])) {
            return false;
        }
        return in_array($permissionName, session()->get('userGroup')['permissions']);
    }

}
