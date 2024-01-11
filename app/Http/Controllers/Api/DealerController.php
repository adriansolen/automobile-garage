<?php

namespace App\Http\Controllers\Api;

use App\Models\Dealer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DealerRequest;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query builder instance
        $query = Dealer::query();

        // Cater Search use "keyword"
        if ($request->has('area') && $request->has('dealer_name')) {
            $query->where(function ($query) use ($request) {
                $query->where('area', 'like', '%' . $request->area . '%')
                    ->where('dealer_name', 'like', '%' . $request->dealer_name . '%');
                // Add more conditions as needed
            });
        }


        // Pagination based on the number set; You can change the number below
        $perPage = 3;
        return $query->paginate($perPage);

        // Show all data; Uncomment if necessary
        // return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    //  change Request to the newly created request folder 
    public function store(DealerRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $dealer = Dealer::create($validated);

        return $dealer;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Dealer::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(DealerRequest $request, string $id)
    {
        $validated = $request->validated();

        $dealer = Dealer::findOrFail($id);

        $dealer->update($validated);

        return $dealer;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dealer = Dealer::findOrFail($id);
        $dealer->delete();

        return $dealer;
    }
}
