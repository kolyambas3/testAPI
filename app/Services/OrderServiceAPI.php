<?php

namespace App\Services;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;

class OrderServiceAPI {
    private Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function createOrder(StoreOrderRequest $orderData)
    {
        $products_data = collect($orderData->products)->mapWithKeys(function ($product) {
            return [$product['id'] => [
                'id' => $product['id'],
                'qty' => isset($product['qty']) ? $product['qty'] : 1
            ]];
        });
        $products = Product::whereIn('id', $products_data->map(function ($product) {
            return $product['id'];
        }))->get();

        $currency = Currency::where('code', ($request->currency ?? 'usd'))->firstOrFail();;
        $this->order->cur = $currency->code;

        $price = 0;
        $this->order->price = $products->map(function ($product) use ($products_data, $price) {
                $price += $product->price * $products_data[$product->id]['qty'];
                return $price;
            })->sum() * $currency->course;

        $this->order->products = $products->map(function ($product) use ($products_data) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'currency' => $product->cur,
                'price' => $product->price * $products_data[$product->id]['qty'],
                'qty' => $products_data[$product->id]['qty']
            ];
        });

        $this->order->save();

        return $this->order;
    }
}

