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
        'time',
        'suburb',
        'suburb_osm_type',
        'suburb_osm_id',
        'city',
        'city_osm_type',
        'city_osm_id',
        'state',
        'state_osm_type',
        'state_osm_id',
        'region',
        'region_osm_type',
        'region_osm_id',
        'country',
    ];

    public function crime() : BelongsTo
    {
        return $this->belongsTo(Crime::class);
    }
}
