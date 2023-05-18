<?php 


namespace Mkhodroo\PaystarTest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mkhodroo\PaystarTest\Models\Order;
use Mkhodroo\PaystarTest\Models\Transaction;
use Symfony\Component\Routing\RequestContext;

class TransactionController extends Controller
{

    public static function create($order_id, $amount, $ref_num, $card_number)
    {
        return Transaction::create([
        'order_id' => $order_id, 
        'amount' => $amount, 
        'ref_num' => $ref_num, 
        'card_number' => $card_number
        ]);
    }

    public static function get_by_ref_num($ref_num)
    {
        return Transaction::where('ref_num', $ref_num)->first();
    }

    public static function make_cancel($ref_num, $paystar_transaction_id)
    {
        $transaction = self::get_by_ref_num($ref_num);
        $transaction->update([
            'paystar_transaction_id' => $paystar_transaction_id,
            'transaction_status' => config('paystarconfig.transaction_status')[1],
        ]);
        return self::get_by_ref_num($ref_num);
    }

    public static function make_pending($ref_num, $paystar_transaction_id, $tracking_code)
    {
        $transaction = self::get_by_ref_num($ref_num);
        $transaction->update([
            'paystar_transaction_id' => $paystar_transaction_id,
            'tracking_code' => $tracking_code,
            'transaction_status' => config('paystarconfig.transaction_status')[2],
        ]);
        return self::get_by_ref_num($ref_num);
    }

    public static function make_not_verified($ref_num)
    {
        $transaction = self::get_by_ref_num($ref_num);
        if($transaction->transaction_status !== config('paystarconfig.transaction_status')[2]){
            return self::get_by_ref_num($ref_num);
        }
        $transaction->update([
            'transaction_status' => config('paystarconfig.transaction_status')[3],
        ]);
        return self::get_by_ref_num($ref_num);
    }

    public static function make_ok($ref_num)
    {
        $transaction = self::get_by_ref_num($ref_num);
        if($transaction->transaction_status !== config('paystarconfig.transaction_status')[2]){
            return self::get_by_ref_num($ref_num);
        }
        $transaction->update([
            'transaction_status' => config('paystarconfig.transaction_status')[0],
        ]);
        return self::get_by_ref_num($ref_num);
    }
}