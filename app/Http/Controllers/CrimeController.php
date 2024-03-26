<?php

namespace App\Http\Controllers;

use App\Http\Requests\Crime\StatisticsCrimeRequest;
use App\Models\Crime;
use App\Models\Report;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'city' => $request->city ?? $request->municipality ?? '',
            'state' => $request->state ?? '',
            'region' => $request->region ?? '',
            'country' => $request->country
        ];

        $date = $request->date;

        $where = array_filter($data, function($value) {
            return !empty($value);
        });

        $crimes = Crime::whereHas('reports', function($query) use ($where, $date) {
            $query->where($where)->whereDate('date', '>=', $date);
        })
        ->withCount(['reports' => function($query) use ($where, $date) {
            $query->where($where)->whereDate('date', '>=', $date);
        }])
        ->withCount(['reports as morning_reports_count' => function($query) use ($where, $date) {
            $query->where($where)->whereDate('date', '>=', $date)
            ->whereRaw('TIME(time) BETWEEN ? AND ?', ['06:00:00', '11:59:59']);
        }])
        ->withCount(['reports as afternoon_reports_count' => function($query) use ($where, $date) {
            $query->where($where)->whereDate('date', '>=', $date)
            ->whereRaw('TIME(time) BETWEEN ? AND ?', ['12:00:00', '17:59:59']);
        }])
        ->withCount(['reports as night_reports_count' => function($query) use ($where, $date) {
            $query->where($where)->whereDate('date', '>=', $date)
            ->whereRaw('TIME(time) BETWEEN ? AND ?', ['18:00:00', '23:59:59']);
        }])
        ->withCount(['reports as dawn_reports_count' => function($query) use ($where, $date) {
            $query->where($where)->whereDate('date', '>=', $date)
            ->whereRaw('TIME(time) BETWEEN ? AND ?', ['00:00:00', '05:59:59']);
        }])
        ->orderBy('name')
        ->get();

        $dict = [
            'suburb' => 'Bairro',
            'city' => 'Cidade',
            'state' => 'Estado',
            'region' => '',
            'country' => ''
        ];

        $data = $where;

        $data_first_key = array_key_first($data);

        $placeReport = $dict[$data_first_key] . ' ' . $data[$data_first_key];

        $response = [
            'crimes' => $crimes,
            'totalReports' => $crimes->sum('reports_count'),
            'morningReports' => $crimes->sum('morning_reports_count'),
            'afternoonReports' => $crimes->sum('afternoon_reports_count'),
            'nightReports' => $crimes->sum('night_reports_count'),
            'dawnReports' => $crimes->sum('dawn_reports_count'),
            'placeReport' => $placeReport,
            'date' => $date,
        ];

        if(count($data) > 1) {
            $dateObject = DateTime::createFromFormat('Y-m-d', $date);
            $formatedDate = $dateObject->format('d-m-Y');
            array_shift($data);
            $data_first_key = array_key_first($data);
            $data_comparison = Report::where($data)->count();
            $percent = ($data_comparison > 0) ? ($response['totalReports'] * 100) / $data_comparison : 0;
            $comparison = $placeReport . ' registrou ' . $response['totalReports'] . ' ocorrência(s), isso equivale a ' . number_format($percent, 0) . '% de todos os ' . $data_comparison . ' crimes registrados no(a) ' . strtolower($dict[$data_first_key]) . ' ' . $data[$data_first_key] . ', levando em consideração os dados de ' . $formatedDate . ' até hoje.';
            $response['comparison'] = $comparison;
        }

        $data = $where;

        if(empty($data['suburb']) && !empty($data['city'])) {
            $response['suburb_comparison'] = Report::select('suburb', DB::raw('count(*) as crime_count'))
                ->whereHas('crime', function($query) use ($where) {
                    $query->where($where);
                })
                ->where('city', $data['city'])
                ->whereDate('date', '>=', $date)
                ->groupBy('suburb')
                ->get();
        } 
        else if(empty($data['city']) && !empty($data['state'])) {
            $state = $data['state'];
            $response['city_comparison'] = DB::table('reports')
                ->join('crimes', 'reports.crime_id', '=', 'crimes.id')
                ->select('city', DB::raw('count(*) as crime_count'))
                ->where($where)
                ->where('state', $state)
                ->whereDate('date', '>=', $date)
                ->groupBy('city')
                ->get();
        } 
        else if(empty($data['state']) && !empty($data['region'])) {
            $region = $data['region'];
            $response['state_comparison'] = DB::table('reports')
                ->join('crimes', 'reports.crime_id', '=', 'crimes.id')
                ->select('state', DB::raw('count(*) as crime_count'))
                ->where($where)
                ->where('region', $region)
                ->whereDate('date', '>=', $date)
                ->groupBy('state')
                ->get();    
        } 
        else if(empty($data['region']) && !empty($data['country'])) {
            $country = $data['country'];
            $response['region_comparison'] = DB::table('reports')
                ->join('crimes', 'reports.crime_id', '=', 'crimes.id')
                ->select('region', DB::raw('count(*) as crime_count'))
                ->where($where)
                ->where('country', $country)
                ->whereDate('date', '>=', $date)
                ->groupBy('region')
                ->get();
        }
        return response()->json($response, 200);
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
