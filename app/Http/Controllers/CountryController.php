<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Http\Resources\StatisticsResource;
use App\Jobs\InsertCountriesData;
use App\Models\Country;
use App\Models\Statistic;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;
        $sortBy = $request->sortBy ?? 'total_confirmed';
        $page = $request->page ?? 1;
        $sortOrder = $request->sortOrder == 'asc' ? 'ASC' : 'DESC';
        $searchQuery = $request->searchTerm;
        $countries = Country::orderBy($sortBy, $sortOrder)->
        when($searchQuery, function ($q) use ($searchQuery) {
            return $q->where('name', 'like', '%' . $searchQuery . '%');
        })->paginate($perPage);
        return CountryResource::collection($countries);
    }

    public function show(Request $request, $country_id)
    {
        $country = Country::where('country_id', $country_id)->first();
        return new CountryResource($country);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:countries,code',
            'newConfirmed' => 'required|integer',
            'totalConfirmed' => 'required|integer',
            'newDeaths' => 'required|integer',
            'totalDeaths' => 'required|integer',
            'newRecovered' => 'required|integer',
            'totalRecovered' => 'required|integer',
        ]);
        $countryData = [
            'name'=> $data['name'],
            'country_id'=> Str::uuid()->toString(),
            'code'=> $data['code'],
            'new_recovered'=> $data['newRecovered'],
            'total_recovered'=> $data['totalRecovered'],
            'new_deaths'=> $data['newDeaths'],
            'total_deaths'=> $data['totalDeaths'],
            'new_confirmed'=> $data['newConfirmed'],
            'total_confirmed'=> $data['totalConfirmed'],
        ];
        $country = Country::create($countryData);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $country = Country::where('country_id', $id)->first();

        $data = $request->validate([
            'name' => 'required|string',
            'code' => 'required|unique:countries,code,' . $country->id,
            'newConfirmed' => 'required|integer',
            'totalConfirmed' => 'required|integer',
            'newDeaths' => 'required|integer',
            'totalDeaths' => 'required|integer',
            'newRecovered' => 'required|integer',
            'totalRecovered' => 'required|integer',
        ]);
        $countryData = [
            'name'=> $data['name'],
            'code'=> $data['code'],
            'new_recovered'=> $data['newRecovered'],
            'total_recovered'=> $data['totalRecovered'],
            'new_deaths'=> $data['newDeaths'],
            'total_deaths'=> $data['totalDeaths'],
            'new_confirmed'=> $data['newConfirmed'],
            'total_confirmed'=> $data['totalConfirmed'],
        ];
        $country = $country->update($countryData);

        return $country;
    }

    /**
     * gets country data using longtiude and latitude
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function searchByLongLat(Request $request)
    {
        try {
            // might need validation
            $longitude = $request->long;
            $latitude = $request->lat;
            $url = 'https://api.tomtom.com/search/2/reverseGeocode/' . $latitude . ',' . $longitude . '.json?key=' . env('TOMTOM_kEY') . '&radius=100';
            log::info($url);
            $response = Http::get($url);
            $countryCode = $response->json()['addresses'][0]['address']['countryCode'];
            $country = Country::where('code', $countryCode)->firstOrFail();
            return new CountryResource($country);
        } catch (\Exception $exception) {
            Log::info($exception);
            return response()->json(['message' => 'Country not found please select another one!'], 404);
        }
    }

    public function getLatestUpdates(Request $request)
    {
        try {
            $response = Http::get('https://api.covid19api.com/summary');
            if ($response->status() == 200) {
                Log::info($globalData = $response->json());
                $globalData = $response->json()['Global'];
                $statisticsData = [
                    'last_update' => Carbon::parse($globalData['Date']),
                    'new_deaths' => $globalData['NewDeaths'],
                    'total_deaths' => $globalData['TotalDeaths'],
                    'new_confirmed' => $globalData['NewConfirmed'],
                    'total_confirmed' => $globalData['TotalConfirmed'],
                    'new_recovered' => $globalData['NewRecovered'],
                    'total_recovered' => $globalData['TotalRecovered'],
                ];

                if (Statistic::count() == 1) {
                    $static = Statistic::first();
                    $static->update($statisticsData);
                } else {
                    $static = Statistic::create($statisticsData);
                }
                $countriesList = $response->json()['Countries'];
                InsertCountriesData::dispatch($countriesList);
                return new StatisticsResource($static);
            }
        } catch (\Exception $exception) {
            Log::info($exception);
            return response()->json([
                'message' => 'Something went wrong , try again later',
                'stats' => new StatisticsResource($static)
            ], 404);
        }
    }
}
