<?php

namespace App\Http\Controllers\Api;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query builder instance
        $query = Sale::query();

        // Cater Search use "keyword"
        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('VIN', 'like', '%' . $request->keyword . '%');
            });
        }

        // Pagination based on the number set; You can change the number below
        $perPage = 6;
        return $query->paginate($perPage);

        // Show all data; Uncomment if necessary
        // return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    //  change Request to the newly created request folder 
    public function store(SaleRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $sale = Sale::create($validated);

        return $sale;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Sale::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(SaleRequest $request, string $id)
    {
        $validated = $request->validated();

        $sale = Sale::findOrFail($id);

        $sale->update($validated);

        return $sale;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->delete();

        return $sale;
    }
}
