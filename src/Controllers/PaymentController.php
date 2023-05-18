<?php 


namespace Mkhodroo\PaystarTest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Mkhodroo\PaystarTest\Models\Transaction;
use Mkhodroo\PaystarTest\Services\PaymentServiceInterface;
use Symfony\Component\Routing\RequestContext;

class PaymentController extends Controller
{
    private $payment;
    public function __construct(PaymentServiceInterface $payment) {
        $this->payment = $payment;
    }

    public function getPayLink(Request $r)
    {
        $order = OrderController::create(Auth::id(), $r->amount); //simple create order record in db

        $response = $this->payment->create($order->id, $order->amount, $r->card_number);
        // error in get token from payment service
        if($response->status != 1){
            return response()->json([
                'message' => "خطا در اتصال به درگاه پرداخت",
                'data' => [
                    'status_code' => $response?->status,
                    'message' => $response?->message
                ]
                ], 400);
        }

        // simple create transaction record in db 
        $transaction = TransactionController::create($order->id, $order->amount, $response->data->ref_num, $r->card_number);
        return response()->json([
            'message' => "در حال انتقال به درگاه پرداخت...",
            'data' => [
                'url' => $this->payment->pay($response->data->token)
            ]
            ]);
    }

    public function callback(Request $r)
    {
        $transaction = TransactionController::get_by_ref_num($r['ref_num']);

        // error in transaction 
        if($r['status'] != 1){
            $transaction = TransactionController::make_cancel($r['ref_num'], $r['transaction_id']);
            return $this->payment->callbackView(
                [
                    'message' => $r['message'],
                    'data' => [
                        'ref_num' => $transaction->ref_num,
                        'paystar_transaction_id' => $r['transaction_id']
                    ]        
                ]
            );
        }

        $transaction = TransactionController::make_pending($r['ref_num'], $r['transaction_id'], $r['tracking_code']);

        return $this->verify($transaction, $r['card_number']);
             
    }

    public function verify(Transaction  $transaction, $card_number)
    {
        $response = $this->payment->verify(
            $transaction->amount, 
            $transaction->ref_num, 
            $card_number,
            $transaction->tracking_code
        );

        if($response->status != 1){
            TransactionController::make_not_verified($transaction->ref_num);
            return $this->payment->callbackView(
                [
                    'message' => $response->message,
                    'data' => [
                        'ref_num' => $transaction->ref_num,
                        'paystar_transaction_id' => $transaction->paystar_transaction_id,
                        'tracking_code' => $transaction->tracking_code
                    ]        
                ]
            );
        }

        TransactionController::make_ok($transaction->ref_num);
        return $this->payment->callbackView(null,
            [
                'message' => $response->message,
                'data' => [
                    'ref_num' => $transaction->ref_num,
                    'paystar_transaction_id' => $transaction->paystar_transaction_id,
                    'tracking_code' => $transaction->tracking_code
                ]       
            ]
        );
    }
}