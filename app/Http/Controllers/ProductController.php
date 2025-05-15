<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Product::with('media')->get());
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
            $validatedData = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'stock' => 'required',
                'category_id' => 'required',
                'fournisseur_id' => 'required',
                
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors in JSON format
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }


        DB::beginTransaction();

        try {
            $product = Product::create([
                'name' => $validatedData['name'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'stock' => $validatedData['stock'],
                'category_id' => $validatedData['category_id'],
                'fournisseur_id' => $validatedData['fournisseur_id'],
            ]);

            DB::commit();

            return response()->json($product->load('media'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product creation failed ', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Product creation failed',
                'context' => ['error' => $e->getMessage()],
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product->load('media'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'stock' => 'sometimes|numeric',
            'category_id' => 'sometimes|exists:categories,id',
            'fournisseur_id' => 'sometimes|exists:fournisseurs,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $product->update($request->only([
                'name',
                'price',
                'description',
                'category_id',
                'fournisseur_id',
                'stock'
            ]));

            DB::commit();

            return response()->json($product->load('media'));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product update failed ', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Product update failed',
                'context' => ['error' => $e->getMessage()],
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try{
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully',
            ]);
        }catch(\Exception $e){
            Log::error('Product deletion failed ', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Product deletion failed',
                'context' => ['error' => $e->getMessage()],
            ], 500);
        }
    }
}
