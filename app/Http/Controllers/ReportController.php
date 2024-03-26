<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\ByCrimeReportRequest;
use App\Http\Requests\Report\StoreReportRequest;
use App\Models\Crime;
use App\Models\Report;
use DateTime;
use GuzzleHttp\Client;
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
     * Display a listing of the resource by crimes.
     */
    public function index_by_crimes(ByCrimeReportRequest $request)
    {
        $date = $request->date;

        $crimes = Crime::whereHas('reports', function ($query) use ($date) {
            $query->whereDate('date','>=', $date);
        })->with(['reports' => function ($query) use ($date) {
            $query->whereDate('date', '>=', $date)
            ->select('crime_id', 'lat', 'lon');   
        }])->get();

        return response()->json($crimes, 200);
    }

    public function get_osm_type_enum($osm_type) {
        switch ($osm_type) {
            case 'node':
                return 'N';
            case 'way':
                return 'W';
            case 'relation':
                return 'R';
            default:
                return null;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReportRequest $request)
    {
        $osm_type = $this->get_osm_type_enum($request->osm_type);

        $client = new Client();

        $url = 'https://nominatim.openstreetmap.org/details.php?osmtype=' . $osm_type . '&osmid=' . $request->osm_id . '&addressdetails=1&format=json';

        $response = $client->request('GET', $url);

        $data = json_decode($response->getBody(), true);

        $reportPlaceData = [
            $request->suburb => [
                'osm_type' => '',
                'osm_id' => '',
            ],
            $request->city => [
                'osm_type' => '',
                'osm_id' => '',
            ],
            $request->state => [
                'osm_type' => '',
                'osm_id' => '',
            ],
            $request->region => [
                'osm_type' => '',
                'osm_id' => '',
            ]
        ];
    
        foreach ($data['address'] as $address) {
            if($address['class'] == 'boundary' && array_key_exists($address['localname'], $reportPlaceData)) {
                $reportPlaceData[$address['localname']]['osm_type'] = $address['osm_type'];
                $reportPlaceData[$address['localname']]['osm_id'] = $address['osm_id'];
            }
        }

        $report = Report::create([
            'crime_id' => $request->crime_id,
            'osm_type' => $osm_type,
            'osm_id' => $request->osm_id,
            'lat' => $request->lat,
            'lon' => $request->lon,
            'date' => $request->date,
            'time' => $request->time,
            'suburb' => $request->suburb,
            'suburb_osm_type' => $reportPlaceData[$request->suburb]['osm_type'],
            'suburb_osm_id' => $reportPlaceData[$request->suburb]['osm_id'],
            'city' => $request->city,
            'city_osm_type' => $reportPlaceData[$request->city]['osm_type'],
            'city_osm_id' => $reportPlaceData[$request->city]['osm_id'],
            'state' => $request->state,
            'state_osm_type' => $reportPlaceData[$request->state]['osm_type'],
            'state_osm_id' => $reportPlaceData[$request->state]['osm_id'],
            'region' => $request->region,
            'region_osm_type' => $reportPlaceData[$request->region]['osm_type'],
            'region_osm_id' => $reportPlaceData[$request->region]['osm_id'],
            'country' => $request->country,
        ]);
        
        return response()->json($report, 201);
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
}
