<?php

namespace App\Api\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $query = Product::query();

            if ($request->has('category_id')) {
                $query->where('category_id', $request->category_id);
            }

            if ($request->has('min_price') && $request->has('max_price')) {
                $query->whereBetween('price', [$request->min_price, $request->max_price]);
            }

            $products = $query->get();

            return response()->json([
                'status_code' => 200,
                'data'        => $products,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message'     => 'An error occurred',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:products|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required',
            'product_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $product = Product::create($validatedData);
            return response()->json([
                'status_code' => 201,
                'message'     => 'Product created successfully',
                'data'        => $product,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message'     => 'An error occurred',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::findOrFail($id);
            return response()->json([
                'status_code' => 200,
                'data'        => $product,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 404,
                'message'     => 'Product not found',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json([
                'status_code' => 404,
                'message'     => 'Product not found',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|unique:products,name,' . $product->id . '|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required',
            'product_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $product->update($validatedData);
            return response()->json([
                'status_code' => 200,
                'message'     => 'Product updated successfully',
                'data'        => $product,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'message'     => 'An error occurred while updating the product',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json([
                'status_code' => 200,
                'message'     => 'Product deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 404,
                'message'     => 'Product not found',
            ], 404);
        }
    }
}