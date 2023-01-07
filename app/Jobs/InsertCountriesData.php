<?php

namespace App\Jobs;

use App\Models\Country;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertCountriesData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $countriesData;

    public function __construct($countriesData)
    {
        $this->countriesData = $countriesData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $countryList = $this->countriesData;
        foreach ($countryList as $country) {
            Country::updateOrCreate([
                'country_id' => $country['ID']
            ], [
                'name' => $country['Country'],
                'code' => $country['CountryCode'],
                'new_recovered' => $country['NewRecovered'],
                'total_recovered' => $country['TotalRecovered'],
                'new_deaths' => $country['NewDeaths'],
                'total_deaths' => $country['TotalDeaths'],
                'new_confirmed' => $country['NewConfirmed'],
                'total_confirmed' => $country['TotalConfirmed'],
            ]);
        }
    }
}
