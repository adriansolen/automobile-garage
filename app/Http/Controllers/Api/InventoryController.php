<?php

namespace App\Http\Controllers\Api;

use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query builder instance
        $query = Inventory::query();

        // Cater Search use "keyword"
        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('dealer', 'like', '%' . $request->keyword . '%')
                    ->orWhere('model_name', 'like', '%' . $request->keyword . '%');
            });
        }

        // Pagination based on the number set; You can change the number below
        $perPage = 3;
        return $query->paginate($perPage);

        // Show all data; Uncomment if necessary
        // return User::all();
    }

    /**
     * Display a listing of the resource.
     */
    public function all(Request $request)
    {
        // Show data based on logged user
        return Inventory::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InventoryRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        // Store in carousel folder the image - uncomment if necessary
        // $validated['image'] = $request->file('image')->storePublicly('user', 'public');

        // Check if the file is present and valid so it will be store in the database
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $validated['image'] = $request->file('image')->storePublicly('inventory', 'public');
        }

        $inventory = Inventory::create($validated);

        return $inventory;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inventory::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InventoryRequest $request, string $id)
    {
        $validated = $request->validated();

        // Check if a file was uploaded
        if ($request->hasFile('image')) {
            // Upload Image to Backend and Store Image Path
            $validated['image'] = $request->file('image')->storePublicly('inventory', 'public');

            // Get Info by Id 
            $inventory = Inventory::findOrFail($id);

            // Delete Previous Image
            if (!is_null($inventory->image)) {
                Storage::disk('public')->delete($inventory->image);
            }

            // Update New Info
            $inventory->update($validated);

            return $inventory;
            }
    
            // If no file was uploaded or if the file is not valid, proceed without updating the image
            // Get Info by Id 
            $inventory = Inventory::findOrFail($id);

            // Update New Info without modifying the image
            $inventory->update($validated);

            return $inventory;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::findOrFail($id);

        //Delete image in laravel
        if (!is_null($inventory->image)) {
            Storage::disk('public')->delete($inventory->image);
        }
        $inventory->delete();
        return $inventory;
    }
}
