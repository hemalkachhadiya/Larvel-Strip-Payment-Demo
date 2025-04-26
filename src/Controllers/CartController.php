<?php
namespace Smarttech\StripePayment\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\DB;
use Smarttech\StripePayment\Models\CartItem;
use Smarttech\StripePayment\Models\Order;
use Smarttech\StripePayment\Models\OrderItem;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $productTable = config('cartstripe.product_table');

        $product = DB::table($productTable)->where('id', $request->product_id)->first();

        $grandTotal = 0;
        if ($product) {
            $total = $product->price * $request->quantity;
            $grandTotal += $total;

            CartItem::updateOrCreate(
                ['product_id' => $request->product_id, 'user_id' => Auth::id()],
                [
                    'quantity' => $request->quantity,
                    'total'    => $grandTotal,
                ]
            );

        }
        return back()->with('success', 'Item added to cart');
    }

    public function showCart()
    {
        $items = CartItem::where('user_id', Auth::id())->get();

        $productTable = config('cartstripe.product_table');

        $cartDetails = [];
        $grandTotal  = 0;

        foreach ($items as $item) {
            $product = DB::table($productTable)->where('id', $item->product_id)->first();

            if ($product) {
                // $total = $product->price * $item->quantity;
                $grandTotal += $item->total;

                $cartDetails[] = [
                    'product'  => $product,
                    'quantity' => $item->quantity,
                    'item'     => $item,
                    // 'total' => $total,
                ];
            }
        }

        return view('cartstripe::cart', [
            'cartDetails' => $cartDetails,
            'grandTotal'  => $grandTotal,
            'items'       => $items,
        ]);
    }

    // public function checkout()
    // {

    //     return view('cartstripe::checkout');
    // }
    public function checkout(Request $request)
    {
        $productIds = (array) $request->input('product_ids'); // array
        $quantities = (array) $request->input('qty');         // array
        $grandTotal = $request->get('grandTotal');    // single value
        $price      = (array) $request->input('price');       // array

        // if ($request->has(['product_ids', 'grandTotal', 'qty'])) {
            $product_id = $productIds;
            $quantity   = $quantities;
            $prices     = $price;
            $amount     = $grandTotal;

            return view('cartstripe::checkout', compact('product_id', 'amount', 'quantity', 'prices'));
        // }

        // return view('cartstripe::checkout');
    }

    public function processCheckout(Request $request)
    {

        $grandTotal = 0;
        $items      = [];

        if ($request->filled(['product_id', 'grandTotal', 'quantity', 'price'])) {

            foreach ($request->product_id as $index => $productId) {
                $items[] = (object) [
                    'product_id' => $productId,
                    'quantity'   => $request->quantity[$index] ?? 1,
                    'price'      => $request->price[$index] ?? 0,
                ];
            }
            $grandTotal = $request->grandTotal;

        } else {
            $items      = CartItem::where('user_id', Auth::id())->get();
            $grandTotal = 0;
            foreach ($items as $item) {
                $grandTotal += $item->total;
            }
        }

        $order = Order::create($request->only(['name', 'email', 'phone', 'address', 'city', 'state']) + [
            'user_id'      => Auth::id(),
            'order_total'  => $grandTotal,
            'order_status' => 'pending',
        ]);
        foreach ($items as $item) {

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $item->product_id,
                'quantity'   => $item->quantity,
                'price'      => (int) $item->price,
            ]);
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price_data' => [
                    'currency'     => 'usd',
                    'product_data' => [
                        'name' => 'Order #' . $order->id,
                    ],
                    'unit_amount'  => intval($grandTotal * 100),
                ],
                'quantity'   => 1,
            ]],
            'mode'                 => 'payment',
            'success_url'          => route('cartstripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('cartstripe.cancel'),
            'metadata'             => [
                'order_id' => $order->id, // Save order ID in metadata for later reference
            ],
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $sessionId = $request->get('session_id');

        if (! $sessionId) {
            return 'Session ID not found.';
        }

        $session = Session::retrieve($sessionId);

        // Stripe ka pura response print karne ke liye
        // dd($session->payment_intent);
        $orderId = $session->metadata->order_id ?? null;

        $order =   Order::where('id', $orderId)->update([
            // 'order_status' => 'paid',
            'payment_intent_id' => $session->payment_intent,
            'payment_status' => 'paid',
        ]);

        CartItem::where('user_id', Auth::id())->delete();

        return view('cartstripe::success');
    }

    public function cancel(Request $request)
    {
        $sessionId = $request->get('session_id');
        $session = Session::retrieve($sessionId);
        $orderId = $session->metadata->order_id ?? null;

        $order =   Order::where('id', $orderId)->update([
            'order_status' => 'cancel',
            'payment_status' => 'cancel',
        ]);

        return view('cartstripe::cancel');
    }

    public function removeItem($id)
{
    $userId = auth()->id(); // Or however you're tracking the cart
    DB::table('cart_items')
        ->where('product_id', $id)
        ->where('user_id', $userId)
        ->delete();

    return response()->json(['success' => true]);
}


}
