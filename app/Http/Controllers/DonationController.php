<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Razorpay\Api\Api;
use App\Models\Donation;
use Illuminate\Support\Facades\Log;

class DonationController extends Controller
{
    public function createOrder(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required',
            'address'=>'required',
            'pincode'=>'required',
            'amount'=>'required|numeric|min:1'
        ]);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => 'donation_'.time(),
            'amount' => $request->amount * 100,
            'currency' => 'INR'
        ]);

        // Save as pending
        $donation = Donation::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'pincode' => $request->pincode,
            'amount' => $request->amount,
            'order_id' => $order['id'],
            'status' => 'pending'
        ]);

        return response()->json([
            'orderId' => $order['id'],
            'currency' => 'INR'
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required',
            'razorpay_order_id' => 'required',
            'razorpay_signature' => 'required'
        ]);

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $generated_signature = hash_hmac('sha256', 
            $request->razorpay_order_id . '|' . $request->razorpay_payment_id, 
            env('RAZORPAY_SECRET')
        );

        $status = ($generated_signature === $request->razorpay_signature) ? 'success' : 'failed';

        // update donation record
        $donation = Donation::where('order_id',$request->razorpay_order_id)->first();
        if($donation){
            $donation->update([
                'payment_id' => $request->razorpay_payment_id,
                'signature' => $request->razorpay_signature,
                'status' => $status,
                'response' => json_encode($request->all())
            ]);
        }

        return response()->json([
            'message' => $status === 'success' ? 'Payment successful 🎉' : 'Payment verification failed!',
            'status' => $status
        ]);
    }
}

