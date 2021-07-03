<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    protected $table = 'products';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('code', 'name');

    public function detailProducts()
    {
        return $this->hasMany('App\DetailProduct');
    }

}
