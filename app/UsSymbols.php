<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsSymbols extends Model
{
    protected $table = 'us_symbols';
    protected $primaryKey = 'symbol';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['symbol', 'exchange', 'currency'];
}
