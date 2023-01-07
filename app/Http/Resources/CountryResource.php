<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->country_id ,
            'name' => $this->name ,
            'code' => $this->code ,
            'newConfirmed' =>  $this->new_confirmed,
            'totalConfirmed' =>  $this->total_confirmed,
            'newDeaths' => $this->new_deaths ,
            'totalDeaths' =>  $this->total_deaths,
            'newRecovered' =>  $this->new_recovered,
            'totalRecovered' => $this->total_recovered ,
            'updatedAt' => Carbon::parse($this->updated_at)->format('d M , Y')
            ];
    }
}
