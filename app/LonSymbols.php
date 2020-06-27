<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LonSymbols extends Model
{
    protected $table = 'lon_symbols';
    protected $primaryKey = 'symbol';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['symbol', 'name', 'exchange', 'currency'];
}
