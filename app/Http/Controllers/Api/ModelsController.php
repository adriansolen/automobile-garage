<?php

namespace App\Http\Controllers\Api;

use App\Models\Models;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModelsRequest;

class ModelsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query builder instance
        $query = Models::query();

        // Cater Search two column and SHOULD CHOOSE TWO 
        if ($request->keyword) {
            $query->where(function ($query) use ($request) {
                $query->where('model_name', 'like', '%' . $request->keyword . '%');
            });
        }

        // Cater Search two column and CAN CHOOSE ONE 
        // if ($request->has('area') || $request->has('dealer_name')) {
        //     $query->where(function ($query) use ($request) {
        //         if ($request->has('area')) {
        //             $query->where('area', 'like', '%' . $request->area . '%');
        //         }
        //         if ($request->has('dealer_name')) {
        //             $query->where('dealer_name', 'like', '%' . $request->dealer_name . '%');
        //         }
        //     });
        // }

        // Cater Search use "dealer_name" one column
        // if ($request->dealer_name) {
        //     $query->where(function ($query) use ($request) {
        //         $query->where('dealer_name', 'like', '%' . $request->dealer_name . '%');
        //     });
        // }


        // Pagination based on the number set; You can change the number below
        $perPage = 3;
        $data = $query->paginate($perPage);

        return response()->json($data);

        // Show all data; Uncomment if necessary
        // return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    //  change Request to the newly created request folder 
    public function store(ModelsRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $model = Models::create($validated);

        return $model;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Models::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(ModelsRequest $request, string $id)
    {
        $validated = $request->validated();

        $model = Models::findOrFail($id);

        $model->update($validated);

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = Models::findOrFail($id);
        $model->delete();

        return $model;
    }
}
