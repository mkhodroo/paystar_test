<?php 

namespace Mkhodroo\PaystarTest\Services;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mkhodroo\PaystarTest\Controllers\CurlController;
use Mkhodroo\PaystarTest\DataModels\CurlResponse;
use stdClass;

class PaystarPaymentService implements PaymentServiceInterface
{
    public function sendRequest($url, $method, $fields): CurlResponse
    {
        // return $fields;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $fields,
            CURLOPT_HTTPHEADER => array(
              'Authorization: Bearer ' . config('paystarconfig.terminal_id'),
              'Content-Type: application/json'
            ),
        ));
          
        $response = curl_exec($curl);
        $response = json_decode($response);
        
        curl_close($curl);
        return  new CurlResponse(
            $response->status ? $response->status : '-100', 
            $response->message ? $response->message : '', 
            $response->data ? $response->data : new stdClass()
        );
    }

    public function create($order_id,$amount, $card_number): CurlResponse
    {
        $callback = route('paystar.callback');
        $fields = [
            'amount' => $amount,
            'order_id' => $order_id,
            'callback' => $callback,
            'card-number' => $card_number,
            'sign' => $this->createSignForCreateMethod($amount, $order_id, $callback),
            'callback_method' => 1
        ];
        $fields = json_encode($fields);
        $fields = str_replace("\\", "", $fields);

        // Log::info(str_replace("\\", "", $fields));
        Log::info('curl send => https://core.paystar.ir/api/pardakht/create');
        return $this->sendRequest(
            config('paystarconfig.urls.create'),
            "POST",
            $fields
        );
    }

    public function pay($token): string
    {
        return config('paystarconfig.urls.pay') . $token;
    }

    public function verify($amount, $ref_num, $card_number, $tracking_code): CurlResponse
    {
        $fields = [
            'amount' => $amount,
            'ref_num' => $ref_num,
            'sign' => $this->createSignForVerifyMethod($amount, $ref_num, $card_number, $tracking_code)
        ];

        $fields = json_encode($fields);
        $fields = str_replace("\\", "", $fields);
        
        Log::info('curl send => https://core.paystar.ir/api/pardakht/verify');
        Log::info($fields);
        return $this->sendRequest(
            config('paystarconfig.urls.verify'),
            "POST",
            $fields
        );
    }

    function callbackView($error = null, $success = null): View
    {
        if($error){
            return view('paystarview::callback')->with([ 'error' => $error ]);
        }
        return view('paystarview::callback')->with([ 'success' => $success ]);
            
       
    }

    public function createSignForCreateMethod($amount, $order_id, $callback)
    {
        return hash_hmac('sha512', "$amount#$order_id#$callback", config('paystarconfig.secret_key'));
    }

    public function createSignForVerifyMethod($amount, $ref_num, $card_number, $tracking_code)
    {
        return hash_hmac('sha512', "$amount#$ref_num#502229******6708#$tracking_code", config('paystarconfig.secret_key'));
    }
}