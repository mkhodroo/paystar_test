<?php

namespace Mkhodroo\PaystarTest\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = "mk_orders";
    protected $fillable = [
        'user_id', 'amount'
    ];
}
