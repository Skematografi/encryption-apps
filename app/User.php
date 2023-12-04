<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'phone', 'password', 'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'datetime'
    ];

    public function role()
    {
        return $this->hasOne('App\Roles', 'id', 'role_id');
    }

    public function getRoleAndPermission($model = null)
    {
        if ($model) {
            $whereModel = [
                ['users.username', '=', $this->username],
                ['permissions.model', '=', $model]
            ];
        } else {
            $whereModel = [
                ['users.username', '=', $this->username],
                ['permissions.model', '<>', $model]
            ];
        }

        $query = DB::table('users')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
            ->leftJoin('access_controls', 'roles.id', '=', 'access_controls.role_id')
            ->leftJoin('permissions', 'access_controls.permission_id', '=', 'permissions.id')
            ->where( $whereModel)
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

        return $result;
    }
}
