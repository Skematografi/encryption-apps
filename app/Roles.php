<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Roles extends Model
{
    use SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsTo('App\User', 'role_id', 'id');
    }

    public function getPermissions()
    {
        $permission = Permission::get();
        $result = [];
        foreach ($permission as $row) {
            $access_control = AccessControl::where([
                ['role_id', '=', $this->id],
                ['permission_id', '=', $row->id]
            ])->first();

            $result[] = [
                'model' => $row->model,
                'permission_id' => $row->id,
                'access_control_id' => $access_control ? $access_control->id : 0,
                'is_view' => $access_control ? $access_control->is_view : 0,
                'is_insert' => $access_control ? $access_control->is_insert : 0,
                'is_edit' => $access_control ? $access_control->is_edit : 0,
                'is_delete' => $access_control ? $access_control->is_delete : 0
            ];
        }

        return $result;
    }
}
