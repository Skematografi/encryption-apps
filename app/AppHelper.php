<?php

namespace App;

use Illuminate\Support\Facades\DB;

class AppHelper
{
    public static function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            return true;
        }

        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }

        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }

        rmdir($dirPath);

        return true;
    }

    public static function generateRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public static function checkAuthorization($role_id, $model)
    {
        $query = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->leftJoin('access_controls', 'roles.id', '=', 'access_controls.role_id')
            ->leftJoin('permissions', 'access_controls.permission_id', '=', 'permissions.id')
            ->where([
                ['users.role_id', '=', $role_id],
                ['permissions.model', '=', $model],
                ['access_controls.is_view', '=', 1]
            ])
            ->exists();

        return $query;
    }

    public static function getRoleAndPermission($model = null, $only_permission = false)
    {

        if ($model) {
            $whereModel = [
                ['users.id', '=', auth()->user()->id],
                ['permissions.model', '=', $model]
            ];
        } else {
            $whereModel = [
                ['users.id', '=', auth()->user()->id],
                ['permissions.model', '<>', $model]
            ];
        }

        $query = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->leftJoin('access_controls', 'roles.id', '=', 'access_controls.role_id')
            ->leftJoin('permissions', 'access_controls.permission_id', '=', 'permissions.id')
            ->where($whereModel)
            ->select(
                'permissions.model',
                'access_controls.is_view',
                'access_controls.is_insert',
                'access_controls.is_edit',
                'access_controls.is_delete'
            )
            ->get();

        $result = [];
        foreach ($query as $row) {
            $result[$row->model] = [
                'is_view' => $row->is_view,
                'is_insert' => $row->is_insert,
                'is_edit' => $row->is_edit,
                'is_delete' => $row->is_delete
            ];
        }

        if ($only_permission) {
            $result = $result[$model];
        }

        return $result;
    }
}
