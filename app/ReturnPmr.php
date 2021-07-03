<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnPmr extends Model
{
    protected $table = 'return_pmr';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array(
                                'out_standing_po_id', 
                                'date_return', 
                                'reception_qty', 
                                'reception_unit', 
                                'rejection_qty', 
                                'rejection_unit', 
                                'example_qty', 
                                'example_unit', 
                                'aql', 
                                'ac_rc', 
                                'description',
                                'print'
                            );
}