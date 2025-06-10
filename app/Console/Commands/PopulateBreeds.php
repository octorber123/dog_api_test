<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Breed;
use App\Services\DogApi;


class PopulateBreeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-breeds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieve all dog breeds from the Dog API and populate the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $dogApi = new DogApi();
        $this->info('Fetching dog breeds from the Dog API...');
        $breeds = $dogApi->allBreeds();
        if (empty($breeds)) {
            $this->error('No breeds found in the Dog API response.');
            return;
        }

        $timestamp = now();
        $this->info('Breeds fetched successfully. Populating the database...');
        $names = array_keys($breeds); 

        foreach ($names as $name) {
            // CHECK IF THE BREED ALREADY EXISTS TO AVOID DUPLICATES
            if (Breed::where('name', $name)->exists()) {
                $this->info("Breed '{$name}' already exists in the database.");
                //TOUCH THE BREED TO UPDATE ITS TIMESTAMP
                Breed::where('name', $name)->update(['updated_at' => now()]);
                $this->info("Updated timestamp for breed: {$name}");
                continue;
            }
            $this->info("Adding breed: {$name}");
            // CREATE THE BREED IN THE DATABASE
            Breed::create(['name' => $name]);
        }

        $this->info('All breeds have been populated successfully.');
        //REMOVE UNTOUCHED BREEDS
        $untouchedBreeds = Breed::where('updated_at', '<', $timestamp)->get();
        if ($untouchedBreeds->isNotEmpty()) {
            $this->info('Removing untouched breeds...');
            foreach ($untouchedBreeds as $breed) {
                $breed->delete();
                $this->info("Removed breed: {$breed->name}");
            }
        } else {
            $this->info('No untouched breeds to remove.');
        }
        $this->info('Database population complete.');

    }
}
