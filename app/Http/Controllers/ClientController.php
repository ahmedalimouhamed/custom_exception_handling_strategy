<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();

        return response()->json($clients);
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
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
            ]);

            $client = Client::create($validated);

            return response()->json($client);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json($e->errors(), 422);
        }
        catch(\Exception $e){
            return response()->json([
                'error' => 'Client creation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        return response()->json($client);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        try{
            $validated = $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
            ]);

            $client->update($validated);

            return response()->json($client);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json($e->errors(), 422);
        }
        catch(\Exception $e){
            return response()->json([
                'error' => 'Client update failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        try{
            $client->delete();

            return response()->json([
                'message' => 'Client deleted successfully'
            ]);
        }catch(\Exception $e){
            return response()->json([
                'error' => 'Client deletion failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
