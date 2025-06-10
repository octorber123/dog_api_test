<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Models\Park;
use App\Models\Breed;
use App\Resources\BreedResource;
use Illuminate\Http\Request;

class ParkBreedController  extends Controller
{
    public function store(Request $request, Park $park) :BreedResource
    {
        $validated = $request->validate([
            'breed_id' => 'required|exists:breeds,id',
        ]);

        $breed = Breed::find($validated['breed_id']); 

        if($park->breedables()->find($validated['breed_id'])) {
            return response()->json(['message' => 'Breed already associated with park.'], 409);
        }

        // I KNOW BREED_ID CAN BE USED INSTEAD, BUT I LIKE TO RETURN MY APIS WITH A RESOURCE
        $park->breedables()->attach($breed);

        return new BreedResource($breed);
    }
}

