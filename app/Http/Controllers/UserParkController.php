<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\User;
use App\Models\Park;
use App\Resources\ParkResource;
use Illuminate\Http\Request;

class UserParkController extends Controller
{
    public function store(Request $request, User $user) :ParkResource
    {
        $validated = $request->validate([
            'park_id' => 'required|exists:parks,id',
        ]);

        $park = Park::find($validated['park_id']);

        if ($user->parkables()->find($validated['park_id'])) {
            return response()->json(['message' => 'Park already associated with User.'], 409);
        }

        // I KNOW PARK_ID CAN BE USED INSTEAD, BUT I LIKE TO RETURN MY APIS WITH A RESOURCE
        $user->parkables()->attach($park);

        return new ParkResource($park);
    }
}

