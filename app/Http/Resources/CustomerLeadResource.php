<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerLeadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'status' => $this->status,
            'orders' => $this->orders,
            'lifetimeValue' => $this->lifetime_value,
            'projectId' => $this->project_id
        ];
    }

    public function search(Request $request)
    {
        $this->validate($request, [
            'q' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'raduis' => 'integer|max:50000',
        ]);

        
        $api_key = Auth::user()->api_key ?? '';
        if ($api_key == '') {
            return response()->json([
                                        'status' => -1,
                                        'message' => "Missing google api key"
                                    ], 200);
        }

        $params = array();
        $params['location'] = $request->latitude . ',' . $request->longitude;

        if ($request->raduis != 0) {
            $params['raduis'] = $request->raduis;
        }

        $googlePlaces = new PlacesApi($api_key);

        $response = $googlePlaces->textSearch($request->q, $params);

        if (!isset($response['next_page_token'])) {
            return response()->json([
                                        'status' => -1,
                                        'message' => "No results found for your search"
                                    ], 200);
        }

        $Search = Search::create([
                                     'q' => $request->q,
                                     'latitude' => $request->latitude,
                                     'longitude' => $request->longitude,
                                     'raduis' => $request->raduis,
                                     'next_page_token' => $response['next_page_token'],
                                     'user_id' => Auth::user()->id
                                 ]);

        $results = $this->handleResultsSearach($Search, $api_key, $response);

        return response()->json([
                                    'status' => 1,
                                    'data' => array(
                                        "results" => $results,
                                        "next_page_token" => $response['next_page_token']
                                    )
                                ], 200);

    }
}
