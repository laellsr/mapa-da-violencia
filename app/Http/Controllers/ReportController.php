<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\StoreReportRequest;
use App\Models\Crime;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(Report::all());
        return response()->json(Report::all(), 200);
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
    public function store(StoreReportRequest $request)
    {
        Report::create($request->all());

        return response()->json([],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }

    /**
     * Display a listing of the resource by crimes.
     */
    public function index_by_crimes()
    {
        $crimes = Crime::has('reports')->with('reports')->get();

        return response()->json($crimes, 200);
    }
}
