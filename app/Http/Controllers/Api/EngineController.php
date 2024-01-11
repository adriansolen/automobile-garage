<?php

namespace App\Http\Controllers\Api;

use App\Models\Engine;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EngineRequest;

class EngineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Engine::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    //  change Request to the newly created request folder 
    public function store(EngineRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $engine = Engine::create($validated);

        return $engine;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Engine::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(EngineRequest $request, string $id)
    {
        $validated = $request->validated();

        $engine = Engine::findOrFail($id);

        $engine->update($validated);

        return $engine;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $engine = Engine::findOrFail($id);
        $engine->delete();

        return $engine;
    }
}
