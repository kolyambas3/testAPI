<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *   path="/orders",
     *   summary="findAllOrders",
     *   @OA\Response(
     *     response=200,
     *     description="A list of orders"
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="an ""unexpected"" error"
     *   )
     * )
     */
    public function index()
    {
        return response()->json([
            Order::paginate(2)
        ]);
    }

    /**
     *
     * @param \Illuminate\Http\Request $request
     * @param Order $order
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Post(
     *   path="/orders",
     *   summary="Save order",
     *   @OA\Response(
     *     response=200,
     *     description="Store order"
     *   ),
     *   @OA\Parameter(
     *      description="Parameter",
     *      in="path",
     *      name="id",
     *      required=true,
     *      @OA\Schema(type="integer"),
     *   ),
     *   @OA\Parameter(
     *      description="Parameter",
     *      in="path",
     *      name="cur",
     *      required=false,
     *      @OA\Schema(type="string"),
     *   ),
     *   @OA\Response(
     *     response="default",
     *     description="no products"
     *   )
     * )
     */
    public function store(StoreOrderRequest $request, Order $order)
    {
        $products_data = collect($request->products)->mapWithKeys(function ($product) {
            return [$product['id'] => [
                'id' => $product['id'],
                'qty' => isset($product['qty']) ? $product['qty'] : 1
            ]];
        });
        $products = Product::whereIn('id', $products_data->map(function ($product) {
            return $product['id'];
        }))->get();

        $currency = Currency::where('code', ($request->cur ?? 'usd'))->firstOrFail();;
        $order->cur = $currency->code;

        $price = 0;
        $order->price = $products->map(function ($product) use ($products_data, $price) {
                $price += $product->price * $products_data[$product->id]['qty'];
                return $price;
            })->sum() * $currency->course;

        $order->products = $products->map(function ($product) use ($products_data) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'cur' => $product->cur,
                'price' => $product->price * $products_data[$product->id]['qty'],
                'qty' => $products_data[$product->id]['qty']
            ];
        });

        $order->save();

        return response()->json([
            $order
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/orders/{id}",
     *     summary="Show a order",
     *     @OA\Parameter(
     *         description="Parameter with mutliple examples",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="int", value="1", summary="An int value."),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json([
            Order::findOrFail($id)
        ]);
    }
}
