<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\FurnitureGood;
use Binafy\LaravelCart\LaravelCart;
use Binafy\LaravelCart\Models\Cart;
use Binafy\LaravelCart\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Redirect;

class FurnitureGoodController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:goods.create', only: ['create', 'store']),
            new Middleware('permission:goods.update', only: ['update', 'edit']),
            new Middleware('permission:goods.delete', only: ['destroy']),
            new Middleware('permission:cart.update', only: ['addToCart']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $goods = FurnitureGood::query()
            ->with('category')
            ->withAvg('ratings as average_rating', 'rating')
            ->when($request->name, fn($q) => $q->where('name', 'LIKE', "%{$request->name}%"))
            ->when($request->min_price, fn($q) => $q->where('price', '>=', $request->min_price))
            ->when($request->max_price, fn($q) => $q->where('price', '<=', $request->max_price))
            ->when($request->category, fn($q) => $q->whereHas('category', fn($q) =>
            $q->where('id', $request->category)))
            ->paginate(15)
            ->withQueryString();

        $categories = Category::pluck('name', 'id');

        return view('goods.index', compact('goods', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('goods.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id'
        ]);

        FurnitureGood::create($validated);

        return Redirect::route('goods.index', $request->query())
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FurnitureGood $good)
    {
        $good->load(['category', 'ratings']);
        return view('goods.show', compact('good'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FurnitureGood $good)
    {
        $categories = Category::all();
        return view('goods.edit', compact('good', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FurnitureGood $good)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id'
        ]);

        $good->update($validated);

        return Redirect::route('goods.index', $request->query())
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FurnitureGood $good)
    {
        $good->delete();

        $queryParams = request()->query();
        $currentPage = request('page', 1);
        $perPage = 10;

        if ((FurnitureGood::count() % $perPage) === 1 && $currentPage > 1) {
            $queryParams['page'] = $currentPage - 1;
        }

        return redirect()->route('goods.index', $queryParams)
            ->with('success', 'Product deleted successfully.');
    }

    public function addToCart(Request $request, FurnitureGood $good)
    {
        $cart = Cart::query()->firstOrCreate(['user_id' => auth()->id()]);

        /** @var CartItem $existedCartGood */
        $existedCartGood = $cart->items()->where('itemable_id', '=', $good->id)->first();

        if ($existedCartGood) {
            $existedCartGood->quantity++;
            $existedCartGood->save();
        } else {
            LaravelCart::storeItem($good, auth()->id());
        }

        return \redirect()->back();
    }
}
