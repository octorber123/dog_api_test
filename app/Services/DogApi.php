<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DogApi
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('dog.base_uri');
    }

    public function allBreeds(): array
    {
        return $this->request('/breeds/list/all');
    }

    public function breedImages(string $breed): array
    {
        $breed = Str::lower($breed);

        return $this->request("/breed/{$breed}/images");
    }

    public function breedImage(string $breed): string
    {
        $breed = Str::lower($breed);

        return $this->request("/breed/{$breed}/images/random");
    }

    private function request(string $endpoint): array|string
    {
        $response = Http::baseUrl($this->baseUrl)
            ->acceptJson()
            ->withoutVerifying()
            ->timeout(10)
            ->get($endpoint)
            ->throw() //INSTEAD OF RECIVING A MASSIVE ERROR STACK TRACE, WE GET A NEAT 500 ERROR, WITH A MESSAGE
            ->json();

        //IF THROW FAILED TO CATCH AN ERROR, WE CAN STILL CHECK THE RESPONSE STATUS 
        //AND THROW A RUNTIME EXCEPTION IF THE API CALL WAS UNSUCCESSFUL
        //THIS IS A GOOD PRACTICE TO ENSURE WE HANDLE ANY UNEXPECTED RESPONSES
        if (($response['status'] ?? null) !== 'success') {
            throw new \RuntimeException("API error for: $endpoint");
        }

        return $response['message'];
    }
}
