<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();

        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $validated = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'total_price' => 'required|numeric',
                'status' => 'required|in:pending,completed,cancelled',
            ]);

            $order = Order::create($validated);

            return response()->json($order);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json($e->errors(), 422);
        }
        catch(\Exception $e){
            return response()->json([
                'error' => 'Order creation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json($order->load('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        try{
            $validated = $request->validate([
                'client_id' => 'required|exists:clients,id',
                'total_price' => 'required|numeric',
                'status' => 'required|in:pending,completed,cancelled',
            ]);

            $order->update($validated);

            return response()->json($order);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json($e->errors(), 422);
        }
        catch(\Exception $e){
            return response()->json([
                'error' => 'Order update failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try{
            $order->delete();

            return response()->json([
                'message' => 'Order deleted successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Order deletion failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
