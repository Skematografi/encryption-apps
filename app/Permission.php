<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'model'
    ];

    public function accessControl()
    {
        return $this->hasOne('App\AccessControl', 'permission_id', 'id');
    }
}
