<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            Order::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if (isset($request->id)) {
            $products_id = explode(',', $request->id);
            $products = Product::whereIn('id', $products_id)->get();

            $productsCount = array();
            foreach (array_count_values($products_id) as $val => $c)
                $productsCount[$val] = $c;

            $order = new Order;
            $currency = Currency::where('code', $request->cur ?: 'usd')->firstOrFail();;
            $order->cur = $currency->code;

            $price = 0;
            $order->price = $products->map(function ($product) use ($price, $productsCount) {
                $price += $product->price * $productsCount[$product->id];
                return $price;
            })->sum() * $currency->course;
            $order->products = $products->map(function ($product) use ($productsCount) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'cur' => $product->cur,
                    'price' => $product->price * $productsCount[$product->id],
                    'qty' => $productsCount[$product->id]
                ];
            });

            $order->save();

            return response()->json([
                $order
            ]);
        }
        return response()->json([
            'Products not found'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json([
            Order::findOrFail($id)
        ]);
    }
}
