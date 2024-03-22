<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Crime extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'heatmap_intensity'
    ];

    public function reports() : HasMany
    {
        return $this->hasMany(Report::class);
    }
}
