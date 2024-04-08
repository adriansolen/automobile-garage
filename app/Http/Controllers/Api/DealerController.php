<?php

namespace App\Http\Controllers\Api;

use App\Models\Dealer;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\DealerRequest;
use Illuminate\Support\Facades\Auth;

class DealerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query builder instance
        $query = Dealer::query();

        // Cater Search two column and SHOULD CHOOSE TWO 
        if ($request->dealer_name) {
            $query->where(function ($query) use ($request) {
                $query->where('dealer_name', 'like', '%' . $request->dealer_name . '%');
            });
        }


        // Cater Search two column and SHOULD CHOOSE TWO 
        // if ($request->has('area') && $request->has('dealer_name')) {
        //     $query->where(function ($query) use ($request) {
        //         $query->where('area', 'like', '%' . $request->area . '%')
        //             ->where('dealer_name', 'like', '%' . $request->dealer_name . '%');
        //     });
        // }

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
        if ($request->dealer_name) {
            $query->where(function ($query) use ($request) {
                $query->where('dealer_name', 'like', '%' . $request->dealer_name . '%');
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
        // $validated = $request->validated();

        // $dealer = Dealer::create($validated);

        // return $dealer;

        // Retrieve the validated input data...
        $validated = $request->validated();

        // Instead of storing an image, store the Google Maps URL
        $validated['map'] = $request->input('map');

        // Create a new vehicle record with the provided data
        $dealer = Dealer::create($validated);

        // Return the created vehicle
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
     * Display the inventory for a specific dealer.
     */
    public function viewInventory(string $id)
    {
        // Find the dealer by dealer_id
        $dealer = Dealer::find($id);

        if (!$dealer) {
            // Handle the case where the dealer is not found
            return response()->json(['error' => 'Dealer not found'], 404);
        }

        // Fetch inventory items for the specified dealer_id
        $inventoryItems = Inventory::where('dealer_id', $id)->get();

        // You can customize the response format based on your needs
        return response()->json(['inventory' => $inventoryItems]);

        // add this in return response if you want to get the information of the dealer 
        // 'dealer' => $dealer, 
    }

    /**
     * Display the inventory of the logged user (Dealer).
     */
    // public function viewLoggedUserInventory(Request $request)
    // {
    //     // Find the logged-in user
    //     $loggedUser = Auth::user();

    //     // Check if the user has the 'dealer' role
    //     // if (!$loggedUser || !$loggedUser->hasRole('dealer')) {
    //     //     return response()->json(['error' => 'Unauthorized'], 401);
    //     // }

    //     // Fetch the dealer's inventory directly through the relationship
    //     $inventoryItems = $loggedUser->dealer->inventory;

    //     // You can customize the response format based on your needs
    //     return response()->json(['inventory' => $inventoryItems]);
    // }


    /**
     * Update the specified resource in storage.
     */
    public function update(DealerRequest $request, string $id)
    {
        // $validated = $request->validated();

        // $dealer = Dealer::findOrFail($id);

        // $dealer->update($validated);

        // return $dealer;

        $validated = $request->validated();

        // Instead of uploading an image, update the Google Maps URL
        $validated['map'] = $request->input('map');

        // Get Info by Id 
        $dealer = Dealer::findOrFail($id);

        // Optionally, delete previous image (if you are no longer storing images)
        // if (!is_null($vehicle->image)) {
        //     Storage::disk('public')->delete($vehicle->image);
        // }

        // Update New Info
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
