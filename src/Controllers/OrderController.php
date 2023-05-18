<?php 


namespace Mkhodroo\PaystarTest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Mkhodroo\PaystarTest\Models\Order;
use Symfony\Component\Routing\RequestContext;

class OrderController extends Controller
{

    public static function create($user_id, $amount)
    {
        return Order::create([
            'user_id' => $user_id,
            'amount' => $amount
        ]);
    }
}