<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Binafy\LaravelCart\Models\Cart;
use Binafy\LaravelCart\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CartController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:cart.update', only: ['removeItems', 'removeOneItem', 'addOneItem']),
            new Middleware('permission:cart.view', only: ['index']),
            new Middleware('permission:order.create', only: ['createOrder']),
        ];
    }
    public function index()
    {
        $cart = Cart::query()->firstOrCreate(['user_id' => auth()->id()]);

        $totalPrice = $cart->items
            ->filter(fn($item) => $item->itemable !== null)
            ->sum(function ($item) {
                return $item->itemable->price * $item->quantity;
            });

        return view('cart.index', [
            'cartItems' => $cart->items,
            'totalPrice' => $totalPrice
        ]);
    }

    public function removeItems(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }
        $cartItem->delete();

        return redirect()->back();
    }

    public function removeOneItem(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        if ($cartItem->quantity > 1) {
            $cartItem->quantity--;
            $cartItem->save();
        } else {
            $cartItem->delete();
        }

        return redirect()->back();
    }

    public function addOneItem(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action');
        }

        $cartItem->quantity++;
        $cartItem->save();

        return redirect()->back();
    }

    public function createOrder(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:255',
            'description' => 'nullable|string|max:255'
        ]);

        \DB::transaction(function () use ($validated) {

            $cart = Cart::query()->firstOrCreate(['user_id' => auth()->id()]);

            $order = Order::create([
                'user_id' => auth()->id(),
                'address' => $validated['address'],
                'description' => $validated['description']
            ]);

            /** @var CartItem $cartItem */
            foreach ($cart->items as $cartItem) {
                $order->items()->create([
                    'good_id' => $cartItem->itemable->id,
                    'name' => $cartItem->itemable->name,
                    'price' => $cartItem->itemable->price,
                    'quantity' => $cartItem->quantity,
                ]);
            }

            $cart->emptyCart();
        });



        return redirect()->route('orders.personal');
    }
}
