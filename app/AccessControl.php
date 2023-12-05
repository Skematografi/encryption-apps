<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessControl extends Model
{
    use SoftDeletes;
    
    protected $table = 'access_controls';

    protected $fillable = [
        'role_id', 'permission_id', 'is_view', 'is_insert', 'is_edit', 'is_delete'
    ];

    public function permissions()
    {
        return $this->belongsTo('App\Permission', 'permission_id', 'id');
    }
}
