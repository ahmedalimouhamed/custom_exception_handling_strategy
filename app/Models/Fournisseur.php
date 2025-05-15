<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Fournisseur extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
