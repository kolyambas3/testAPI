<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderServiceAPI;

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
     * @param StoreOrderRequest $request
     * @param OrderServiceAPI $orderServiceAPI
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
    public function store(StoreOrderRequest $request, OrderServiceAPI $orderServiceAPI)
    {
        $order = $orderServiceAPI->createOrder($request);
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
