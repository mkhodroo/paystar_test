<?php

namespace Mkhodroo\PaystarTest\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $table = "mk_transactions";
    protected $fillable = [
        'order_id', 'amount', 'ref_num', 'card_number', 'paystar_transaction_id', 'tracking_code', 'transaction_status', 'transaction_result'
    ];
}
