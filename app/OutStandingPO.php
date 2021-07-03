<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutStandingPO extends Model
{
    protected $table = 'out_standing_po';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('no_po', 'date_po', 'detail_products_id', 'suppliers_id', 'stock');
}
