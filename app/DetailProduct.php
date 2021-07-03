<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailProduct extends Model
{
    protected $table = 'detail_products';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('products_id', 'description', 'code_item', 'item', 'unit');



    public function products()
    {
        return $this->belongsTo('App\Product');
    }
}
