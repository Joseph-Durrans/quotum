<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GbSymbols extends Model
{
    protected $table = 'gb_symbols';
    protected $primaryKey = 'symbol';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['symbol', 'exchange', 'currency'];
}
