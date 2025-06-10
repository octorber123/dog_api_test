<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    protected $fillable = ['name'];

    public function users()
    {
        return $this->morphToMany(User::class, 'parkable');
    }

    public function breeds()
    {
        return $this->morphToMany(Breed::class, 'breedable');
    }
}
