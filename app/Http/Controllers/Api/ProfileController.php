<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Update the image of the token bearer from storage.
     */
    public function image(UserRequest $request)
    {
        $user = User::findOrFail($request->user()->id);

        if (!is_null($user->image)) {
            Storage::disk('public')->delete($user->image);
        }

        $user->image = $request->file('image')->storePublicly('images', 'public');

        $user->save();

        return $user;
    }

    /**
     * Display the specified information of the token bearer.
     */
    public function showProfile(Request $request)
    {
        return $request->user();
    }

    /**
     * Display the specified information (user and inventory) of the token bearer.
     */
    public function showInventory(Request $request)
    {
        // Get the user with their inventory
        $user = $request->user()->load('inventory');

        // If a keyword is provided, filter the inventory items
        $keyword = $request->input('keyword');
        $inventoryItems = $user->inventory();

        if ($keyword) {
            $inventoryItems->where('model_name', 'like', '%' . $keyword . '%')
                ->orWhere('VIN', 'like', '%' . $keyword . '%')
                ->orWhere('category', 'like', '%' . $keyword . '%');
        }

        // Paginate the filtered inventory items with 3 items per page (adjust as needed)
        $inventoryItems = $inventoryItems->paginate(3);

        return response()->json(['inventory' => $inventoryItems]);
    }
}
