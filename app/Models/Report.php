<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'crime_id',
        'osm_type',
        'osm_id',
        'lat',
        'lon',
        'date',
        'time'
    ];

    public function crime() : BelongsTo
    {
        return $this->belongsTo(Crime::class);
    }
}
