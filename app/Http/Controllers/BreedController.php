<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

use App\Models\Breed;
use App\Services\DogApi;
use App\Http\Resources\BreedResource;

class BreedController extends Controller
{
    private DogApi $dog;

    public function __construct(DogApi $dog)
    {
        $this->dog = $dog;
    }

    public function index() : AnonymousResourceCollection
    {
       return BreedResource::collection(Breed::all());
    }

    public function show(Breed $breed) : BreedResource
    {
        return new BreedResource($breed);
    }

    public function random() : BreedResource
    {
        $breed = Breed::all()->random();
        return new BreedResource($breed);
    }

    public function getBreedImage(Breed $breed)
    {
        $breed_name = $breed->name;
        
        return response()->json([
            'breed' => $breed_name,
            'image' => $this->dog->breedImage($breed_name),
        ]);
    }
}
