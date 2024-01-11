<?php

namespace App\Http\Controllers\Api;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query builder instance
        $query = Vehicle::query();

        // Cater Search use "keyword"
        // if ($request->keyword) {
        //     $query->where(function ($query) use ($request) {
        //         $query->where('price', 'like', '%' . $request->keyword . '%');
        //         // ->orWhere('price', 'like', '%' . $request->keyword . '%');
        //     });
        // }

        if ($request->has('min_price') && $request->has('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // Pagination based on the number set; You can change the number below
        $perPage = 3;
        return $query->paginate($perPage);

        // Show all data; Uncomment if necessary
        // return vehicle::all();
    }

    /**
     * Display a listing of the resource.
     */
    public function all(Request $request)
    {
        // Show data based on logged vehicle
        return Vehicle::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VehicleRequest $request)
    {
        // $validated = $request->validated();

        // $validated['password'] = Hash::make($validated['password']);

        // $vehicle = vehicle::create($validated);

        // return $vehicle;

        // Retrieve the validated input data...
        $validated = $request->validated();

        // Store in carousel folder the image
        $validated['image'] = $request->file('image')->storePublicly('vehicle', 'public');

        $vehicle = Vehicle::create($validated);

        return $vehicle;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Vehicle::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VehicleRequest $request, string $id)
    {
        $validated = $request->validated();

        // Upload Image to Backend and Store Image Path
        $validated['image'] = $request->file('image')->storePublicly('vehicle', 'public');

        // Get Info by Id 
        $vehicle = Vehicle::findOrFail($id);

        // Delete Previous Image
        if (!is_null($vehicle->image)) {
            Storage::disk('public')->delete($vehicle->image);
        }

        // Update New Info
        $vehicle->update($validated);

        return $vehicle;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicle = Vehicle::findOrFail($id);
        Storage::disk('public')->delete($vehicle->image);
        $vehicle->delete();
        return $vehicle;
    }
}
