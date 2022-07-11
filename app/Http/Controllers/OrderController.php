<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //

    public function index()
    {
        $orders = Order::all();

        return response($orders, 200);
    }


        /**
     * @OA\Get(
     *      path="/orders/{order_id}",
     *      operationId="getProjectById",
     *      tags={"Projects"},
     *      summary="Get project information",
     *      description="Returns project data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Project id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     *      security={
     *         {
     *             "oauth2_security_example": {"write:projects", "read:projects"}
     *         }
     *     },
     * )
     */

    public function store(Request $request)
    {
        $post_data = $request->validate([
            "price" => "integer",
            "order_status" => "string|required",
            "quantity" => "integer",
        ]);


        $new_order = Order::create([
            "price" => $post_data['price'],
            "order_status" => $post_data['order_status'],
            "quantity" => $post_data['quantity'],
            "user_id" => auth()->user()->id
        ]);


        $response = [
            "message" => "Order created",
            "order" => $new_order
        ];

        return response($response, 201);
    }

    public function show($order_id)
    {
        $order = Order::findOrFail($order_id);

        $response = [
            "order" => $order
        ];
        return response($response, 200);
    }

    public function update(Request $request, $task_id)
    {

        $order_to_update = Order::findOrFail($task_id);

        $post_data = $request->validate([
            "price" => "integer",
            "quantity" => "integer",
        ]);

        $order_to_update->price = $post_data['price'];
        $order_to_update->order_status = $post_data['order_status'];
        $order_to_update->quantity = $post_data['quantity'];

        $order_to_update->save();

        return response($order_to_update, 200);
    }

    public function destroy($order_id)
    {
        $order_to_delete = Order::findOrFail($order_id);

        $order_to_delete->delete();

        return 204;
    }

    public function returnUserForOrder($order_id)
    {
        $order = Order::findOrFail($order_id);

        $user_for_order = $order->user;

        return response([
            "user"=>$user_for_order
        ], 200);
    }

    public function returnOrdersForCurrentUser(Request $request){
        $user = Order::all();

        return response($user,200);
    }
}
