<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tool extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'description'];

    public function receipts(): BelongsToMany
    {
        return $this->belongsToMany(Receipt::class);
    }
}
