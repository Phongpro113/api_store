<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::paginate(10);

        return response()->json($stores);

        // return StoreResource::collection($stores);
    }

    public function show($id)
    {
        $store = Store::where('id', $id)->first();

        return response()->json($store);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $exitsName = Store::where('name', $request->name)->first();

        if(!empty($exitsName)) {
            return response()->json([
                'status' => false,
                'message' => 'name exits'
            ]);
        }

        $store = Store::create([
            'name' => $validatedData['name'],
            'user_id' => auth('api')->id(),
            'address' => $request->address ?? '',
            'phone' => $request->phone ?? '',
            'email' => $request->email ?? '',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'create store successfully'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'user_id' => 'required|string',
            'address' =>'nullable',
            'phone' => 'nullable',
            'email' => 'nullable',
        ]);

        $store = Store::findOrFail($id);
        $store->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'update successfully'
        ], 200);
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return response()->json([
            'message' => 'Store deleted successfully.',
            'status'    => 'deleted',
        ], 204);
    }
}
