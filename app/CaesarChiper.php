<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaesarChiper extends Model
{
    protected $table = 'caesar_chiper';
    protected $fillable = ['key', 'value'];
}
