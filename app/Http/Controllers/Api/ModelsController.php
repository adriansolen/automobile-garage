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
    public function index()
    {
        return Models::all();
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
