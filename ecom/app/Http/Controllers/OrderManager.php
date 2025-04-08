<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\Orders;
use Stripe\StripeClient;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;


class OrderManager extends Controller
{
    function showCheckout()
    {
        return view('checkout');
    }

    function checkout(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'pincode'=> 'required',
            'phone' => 'required',
        ]);

        $cartItems = DB::table('cart')
            ->select('product_id', DB::raw('count(*) as quantity'))
            ->where('user_id', auth()->user()->id)
            ->groupBy('product_id')
            ->get();

        if($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'No items in cart');
        }

        $productIds = $cartItems->pluck('product_id')->toArray();
        $products = Products::whereIn('id', $productIds)->get();

        $productIds = [];
        $quantities = [];
        $totalPrice = 0;
        $lineItems = [];   

        foreach($cartItems as $item) {
            $productIds[] = $item->product_id;
            $quantities[] = $item->quantity;

            $product = $products->firstWhere('id', $item->product_id);
            if ($product) {
                $totalPrice += $product->price * $item->quantity;
            }

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $item->quantity,
            ];

            
        }

        $order = new Orders();
        $order->user_id = auth()->user()->id;
        $order->address = $request->address;
        $order->phone = $request->phone;
        $order->product_id = json_encode($productIds);
        $order->total_price = $totalPrice;
        $order->quantity = json_encode($quantities);

        if ($order->save()) {
            DB::table('cart')->where('user_id', auth()->user()->id)->delete();

            $stripe = new StripeClient(config("app.STRIPE_KEY"));

            $checkoutSession = $stripe->checkout->sessions->create([
                'success_url' => route('payment.success',
                ['order_id' => $order->id]),
                'cancel_url' => route('payment.error'),
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'customer_email' => auth()->user()->email,
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            return redirect($checkoutSession->url);
        } 
        return redirect()->route('cart.show')->with('error', 'Failed to place order'); 
        
    }

    function paymentError()
    {
        return 'payment.error';
    }

    function paymentSuccess($order_id)
    {
        return 'payment.success' .$order_id;
    }

    function webhookStripe(Request $request) {
        $endpointSecret = config('app.STRIPE_WEBHOOK_SECRET');
        $payload= $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try{
            $event = Webhook::constructEvent(
                $payload,$sigHeader,$endpointSecret
            );
        } catch(\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch(SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = $session->metadata->order_id;
            $paymentId = $session->payment_intent;

            $order = Orders::find($orderId);
            if($order) {
                $order->payment_id = $paymentId;
                $order->status = 'payment_completed';
                $order->save();
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    function orderHistory()
    {
    $orders = Orders::where('user_id', auth()->user()->id)->paginate(5);
    if ($orders->isEmpty()) {
        return redirect()->back()->with('error', 'No orders found');
    }

    $orders->getCollection()->transform(function ($order) {
        $productIds = json_decode($order->product_id, true);
        $quantities = json_decode($order->quantity, true);

        $products = Products::whereIn('id', $productIds)->get();

        $order->products_details = $products->map(function ($product) use ($quantities, $productIds) {
            $index = array_search($product->id, $productIds);

            return [
                'title' => $product->title,
                'quantity' => $quantities[$index] ?? 0,
                'price' => $product->price,
                'slug' => $product->slug,
                'image' => $product->image,
            ];
        });

        return $order;
    });

    return view('history', compact('orders'));
    }
}
