<?php

namespace App\Http\Controllers;

use App\Http\Requests\Crime\StatisticsCrimeRequest;
use App\Models\Crime;
use Illuminate\Http\Request;

class CrimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Crime::all(), 200);
    }

    public function statistics(StatisticsCrimeRequest $request) {
        $data = [
            'suburb' => $request->suburb ?? '',
            'city' => $request->city ?? '',
            'state' => $request->state ?? '',
            'region' => $request->region ?? '',
            'country' => $request->country
        ];

        $where = array_filter($data, function($value) {
            return !empty($value);
        });

        // $crimes = Crime::has('reports')
        // ->with(['reports' => function($query) use ($where){
        //     $query->select('crime_id')->where($where);        
        // }])->get();

        $crimes = Crime::whereHas('reports', function($query) use ($where) {
            $query->where($where);
        })->withCount(['reports' => function($query) use ($where) {
            $query->where($where);
        }])->get();

        return response()->json([$crimes, $crimes->sum('reports_count')], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Crime $crime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Crime $crime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Crime $crime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Crime $crime)
    {
        //
    }
}
