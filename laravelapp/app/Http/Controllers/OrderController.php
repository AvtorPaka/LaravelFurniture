<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:order.view.global', only: ['index']),
            new Middleware('permission:order.view.local', only: ['myOrders']),
            new Middleware('permission:order.modify', only: ['edit', 'update', 'destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::paginate(15);

        return view('orders.index', compact('orders'));
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', '=', auth()->id())->paginate(15);

        return view('orders.index', compact('orders'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return view('orders.edit', [
            'order' => $order,
            'statusOptions' => ['pending', 'fulfilled', 'cancelled']
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,fulfilled,cancelled'
        ]);

        $order->update($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Order status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order successfully deleted.');
    }
}
