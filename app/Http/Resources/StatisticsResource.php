<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatisticsResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'lastUpdate' => $this->last_update,
            'stats'=>[
                'recovered'=>[
                    'new' => $this->new_recovered,
                    'total' => $this->total_recovered,
                    "title"=> "recovered"
                ],
                'confirmed'=>[
                    'new' => $this->new_confirmed,
                    'total' => $this->total_confirmed,
                    "title"=> "confirmed"
                ],
                'deaths'=>[
                    'new' => $this->new_deaths,
                    'total' => $this->total_deaths,
                    "title"=> "Deaths"
                ] ,
            ]
        ];
    }
}
