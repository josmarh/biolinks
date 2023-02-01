<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest;
use App\Http\Requests\ProspectRequest;
use App\Prospect;
use App\Models\Search;
use App\Services\ProspectService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use SKAgarwal\GoogleApi\PlacesApi;
use App\Models\SearchResults;

class LeadController extends Controller
{
    private $prospectService;

    public function __construct(ProspectService $prospectService)
    {
        $this->prospectService = $prospectService;
    }

    public function index()
    {
        //dd(Auth::user()->prospects());
        $prospects = Auth::user()->prospects()->orderBy('id', 'desc')->get();

        return response()->json([
                                    'status' => 1,
                                    'data' => $prospects
                                ]);
    }

    public function search(Request $request)
    {
        // $this->validate($request, [
        //     'q' => 'required',
        //     'latitude' => 'required',
        //     'longitude' => 'required',
        //     'raduis' => 'integer|max:50000',
        // ]);

        $api_key = Auth::user()->key ?? '';


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



        // $response = $googlePlaces->textSearch($request->q, $params);

        // return response()->json([
        //     'ee' => $response['next_page_token'] 
        // ]);

        return response()->json([
            'google playces'=> $googlePlaces
        ]);

        // if (!isset($response['next_page_token'])) {
        //     return response()->json([
        //                                 'status' => -1,
        //                                 'message' => "No results found for your search"
        //                             ], 200);
        // }

        // $Search = Search::create([
                        //      'q' => $request->q,
                        //      'latitude' => $request->latitude,
                        //      'longitude' => $request->longitude,
                        //      'raduis' => $request->raduis,
                        //      'next_page_token' => $response['next_page_token'],
                        //      'user_id' => Auth::user()->id
                        //  ]);

        // $results = $this->handleResultsSearach($Search, $api_key, $response);

        // return response()->json([
                                //     'status' => 1,
                                //     'data' => array(
                                //         "results" => $results,
                                //         "next_page_token" => $response['next_page_token']
                                //     )
                                // ], 200);
    }

    public function handleResultsSearach($Search, $key, $response)
    {
        $results = array();

        if (1 == 1) {
            foreach ($response['results'] as $result) {
                $SearchResults = SearchResults::where("place_id", $result['place_id'])->first();
                if ($SearchResults) {
                    $SearchResults->prospect = Auth::user()->prospects()->where(
                        'place_id',
                        $SearchResults->place_id
                    )->first();
                    $results[] = $SearchResults;
                    continue;
                }
                $details = $this->get_google_details_place($key, $result['place_id']);

                $detailsData = $details["result"];
                $SearchResults_ = array(
                    "adresse" => $detailsData['formatted_address'] ?? '',
                    "phone" => isset($detailsData['formatted_phone_number']) ? $detailsData['formatted_phone_number'] : '',
                    "name" => isset($detailsData['name']) ? $detailsData['name'] : '',
                    "types" => isset($detailsData['types']) ? $detailsData['types'] : '',
                    "ratings" => isset($detailsData['user_ratings_total']) ? $detailsData['user_ratings_total'] : '',
                    "url" => isset($detailsData['website']) ? $detailsData['website'] : '',
                    'place_id' => $result['place_id'],
                    'country' => '',
                    'city' => "",
                    'search_id' => $Search->id,
                    "address_components" => isset($detailsData['address_components']) ? $detailsData['address_components'] : '',
                    'email' => ""
                );

                if (strpos($SearchResults_['url'], 'facebook') !== false || $SearchResults_['url'] == '') {
                    continue;
                }
                $results[] = $this->CreateSearchResults($SearchResults_);
            }
        }
        return $results;
    }

    public function get_google_details_place($key, $place_id)
    {
        $googlePlaces = new PlacesApi($key);
        return $googlePlaces->placeDetails($place_id);
    }

    public function CreateSearchResults($result)
    {
        $result['types'] = implode(",", $result['types']);

        if ($result['url'] != '') {
            $result['email'] = $this->scrapEmailFromUrl($result['url']);
        }
        $result['country'] = $this->getCounty($result['address_components']);
        $result['city'] = $this->getCity($result['address_components']);


        $SearchResults = SearchResults::create($result);

        $SearchResults->prospect = Auth::user()->prospects()->where('place_id', $SearchResults->place_id)->first();
        return $SearchResults;
    }

    public function scrapEmailFromUrl($url)
    {
        $callback = @file_get_contents($url);
        if ($callback !== false) {
            $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,4})(?:\.[a-z]{2})?/i';
            preg_match_all($pattern, $callback, $matches);

            if (isset($matches[0])) {
                $email = (isset($matches[0][0])) ? $matches[0][0] : "";
                if (strpos($email, 'sentry') !== false) {
                    return $email;
                }
                return (isset($matches[0][1])) ? $matches[0][1] : "";
            }
        } else {
            return "";
        }
    }

    public function getCounty($address_components)
    {
        $country = "";
        foreach ($address_components as $address_component) {
            if (in_array('country', $address_component["types"])) {
                $country = $address_component['long_name'];
            }
        }
        return $country;
    }

    public function getCity($address_components)
    {
        $city = "";
        foreach ($address_components as $address_component) {
            if (in_array('locality', $address_component["types"])) {
                $city = $address_component['long_name'];
            }
        }
        return $city;
    }
    public function load_more(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        $ReportSettings = $this->user->ReportSettings()->whereNull('report_id')->first();

        if (!$ReportSettings) {
            return response()->json([
                                        'status' => -1,
                                        'message' => "key not found"
                                    ], 200);
        }

        if ($ReportSettings->google_key == '') {
            return response()->json([
                                        'status' => -1,
                                        'message' => "Missing google api key"
                                    ], 200);
        }


        $Search = Search::where("next_page_token", $request->token)->first();

        if (!$Search) {
            return response()->json([
                                        'status' => -1,
                                        'message' => "Invalid search token"
                                    ], 200);
        }


        $googlePlaces = new PlacesApi($ReportSettings->google_key);
        $response = $googlePlaces->load_more($request->token);

        if (!isset($response['results'])) {
            return response()->json([
                                        'status' => -1,
                                        'message' => "No more results found for your search"
                                    ], 200);
        }


        $Search = $Search->replicate();
        $Search->next_page_token = (isset($response['next_page_token'])) ? $response['next_page_token'] : "dsfvezrzthyhyfghhppmlju45d4f8sdf";
        $Search->save();

        $results = $this->handleResultsSearach($Search, $ReportSettings->google_key, $response);

        return response()->json([
                                    'status' => 1,
                                    'data' => array(
                                        "results" => $results,
                                        "next_page_token" => (isset($response['next_page_token'])) ? $response['next_page_token'] : ""
                                    )
                                ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            //'name'         => 'required',
            // 'description'   => 'required|max:255',
            //'url'           => 'required|url',
            //'email'           => 'required|email',
            //'phone'           => 'required|string'
        ]);
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        $prospect = new Prospect();
        $prospect->fill($input);
        $prospect->name = $request->name;
        $prospect->user_id = Auth::user()->id;

        $prospect->client = $request->client;
        $prospect->url = $request->url;
        $prospect->save();

        return response()->json([
                                    'status' => 1,
                                    'data' => $prospect
                                ], 200);
    }

    public function update(ProspectRequest $request, $id)
    {
        return $this->prospectService->update($request, $id);
    }

    public function destroy(int $id)
    {
        return $this->prospectService->destroy($id);
    }

    public function autocomplete(Request $request, $search_query)
    {
        // $data =  $this->user->prospect()
        //         ->Where('name', 'like', '%'. $search_query .'%')
        //         ->orWhere('url', 'like', '%'. $search_query .'%')
        //         ->orWhere('adresse', 'like', '%'. $search_query .'%')
        //         ->orWhere('phone', 'like', '%'. $search_query .'%')
        //         ->orWhere('email', 'like', '%'. $search_query .'%')
        //         ->orWhere('city', 'like', '%'. $search_query .'%')
        //         ->orWhere('country', 'like', '%'. $search_query .'%');

        $data = DB::select(
            'select * from prospect where user_id = ' . $this->user->id . ' and
                                    ( name like ?
                                    or url like ?
                                    or adresse like ?
                                    or phone like ?
                                    or email like ?
                                    or city like ?
                                    or country like ?
                                    )
        ',
            [
                '%' . $search_query . '%',
                '%' . $search_query . '%',
                '%' . $search_query . '%',
                '%' . $search_query . '%',
                '%' . $search_query . '%',
                '%' . $search_query . '%',
                '%' . $search_query . '%',
            ]
        );

        if (auth()->user()->team_id) {
            $data = DB::select(
                'select * from prospect where team_id = ' . auth()->user()->team_id . ' and
                                        ( name like ?
                                        or url like ?
                                        or adresse like ?
                                        or phone like ?
                                        or email like ?
                                        or city like ?
                                        or country like ?
                                        )
                            ',
                [
                    '%' . $search_query . '%',
                    '%' . $search_query . '%',
                    '%' . $search_query . '%',
                    '%' . $search_query . '%',
                    '%' . $search_query . '%',
                    '%' . $search_query . '%',
                    '%' . $search_query . '%',
                ]
            );
        }

        return response()->json([
                                    'status' => 1,
                                    'data' => $data
                                ], 200);
    }

    public function sendMail(MailRequest $request)
    {
        return $this->prospectService->sendMail($request);
    }
}