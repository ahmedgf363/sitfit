<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function quickOrder(Product $product)
    {
        $userId = Auth::id();

        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'user_id'    => $userId,
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        return redirect()->route('checkout.index');
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $cartItems = CartItem::where('user_id', $user->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        // جلب العنوان لعدم حدوث خطأ Undefined variable $address
        $address = Address::where('user_id', $user->id)->latest()->first();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shipping = 0.00;
        $tax = $subtotal * 0.14;
        $discount = 0.00;
        $total = $subtotal + $shipping + $tax - $discount;

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'shipping',
            'tax',
            'discount',
            'total',
            'address'
        ));
    }

    public function store(Request $request)
    {
        // Validation بسيط للتجربة السريعة
        $request->validate([
            'fullname'        => 'required|string|max:255',
            'phone'           => 'required|string|max:20',
            'email'           => 'required|email',
            'country'         => 'required|string|max:255',
            'city'            => 'required|string|max:255',
            'street'          => 'required|string|max:255',
            'building'        => 'required|string|max:255',
            'delivery_method' => 'nullable|string',
            'payment_method'  => 'nullable|string',
        ]);

        $order = null;

        DB::transaction(function () use ($request, &$order) {
            $user = Auth::user();

            $cartItems = CartItem::where('user_id', $user->id)
                ->with('product')
                ->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('Cart is empty');
            }

            $subtotal = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });

            $shipping = 0;
            $tax = $subtotal * 0.14;
            $discount = 0;
            $total = $subtotal + $shipping + $tax - $discount;

            $address = Address::create([
                'user_id'          => $user->id,
                'label'            => 'Home',
                'country'          => $request->country,
                'city'             => $request->city,
                'street'           => $request->street,
                'building_number'  => $request->building,
                'floor'            => null,
                'apartment_number' => $request->apartment ?? null,
                'postal_code'      => $request->zip ?? null,
            ]);

            $order = Order::create([
                'user_id'     => $user->id,
                'address_id'  => $address->id,
                'total_price' => $total,
                'status'      => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);
            }

            CartItem::where('user_id', $user->id)->delete();

            session()->flash('order_id', $order->id);
        });

        if (!$order) {
            return redirect()->route('cart.index');
        }

        return redirect()->route('checkout.success', $order->id);
    }

    public function success(Order $order)
    {
        abort_if($order->user_id != Auth::id(), 403);

        return view('checkout.success', compact('order'));
    }
}