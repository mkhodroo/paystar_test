<?php 


namespace Mkhodroo\PaystarTest\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mkhodroo\PaystarTest\Services\PaymentServiceInterface;

class CheckoutController extends Controller
{
    private $payment;
    public function __construct(PaymentServiceInterface $payment) {
        $this->payment = $payment;
    }

    public static function index( $error = null)
    {
        Auth::loginUsingId(1);
        return view('paystarview::checkout')->with([
            'error' => $error
        ]);
    }
}