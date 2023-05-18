<?php 

namespace Mkhodroo\PaystarTest\Services;

use Illuminate\Contracts\View\View;
use Mkhodroo\PaystarTest\DataModels\CurlResponse;

interface PaymentServiceInterface
{
    public function sendRequest($url, $method, $fields): CurlResponse;
    public function create(string $order_id,int $amount, string $card_number): CurlResponse;
    public function pay(string $token): string;
    public function verify(int $amount, string $ref_num, string $card_number, string $tracking_code): CurlResponse;
    public function callbackView($error = null, $success = null): View;
}