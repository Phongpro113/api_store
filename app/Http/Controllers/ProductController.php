<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Products::paginate(10);

        return response()->json($products);

        // return StoreResource::collection($stores);
    }

    public function show($id)
    {
        $product = Products::where('id', $id)->first();

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'store_id' => 'nullable',
        ]);

        $exitsName = Products::where('name', $request->name)->first();

        if(!empty($exitsName)) {
            return response()->json([
                'status' => false,
                'message' => 'name exits'
            ]);
        }

        $product = Products::create([
            'name' => $validatedData['name'],
            'store_id' => $validatedData['store_id'],
            'description' => $request->description ?? '',
            'price' => $request->price ?? 0,
            'image' => 'image',

        ]);

        return response()->json([
            'status' => true,
            'message' => 'create Product successfully'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'store_id' => 'required',
            'description' => 'nullable',
            'price' => 'nullable',
            'image' => 'nullable',
        ]);

        $product = Products::findOrFail($id);
        $product->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'update successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.',
            'status'    => 'deleted',
        ], 204);
    }
}
