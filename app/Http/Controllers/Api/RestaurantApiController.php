<?php

namespace App\Http\Controllers\Api;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use App\Models\Vacancy;
use Illuminate\Http\Response;


class RestaurantApiController extends Controller
{
    public function index()
    {
        return RestaurantResource::collection(Restaurant::with('vacancies')->get());
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $restaurant = Restaurant::create($request->all());
        return new RestaurantResource($restaurant);
    }

    public function create()
    {
        $user = auth()->user();

        return response([
            'meta' => [
                'vacancies' => Vacancy::get(['id', 'name']),
            ],
        ]);
    }


    public function show(Restaurant $restaurant)
    {
        return new RestaurantResource($restaurant->load('vacancies'));
    }

    public function update(Request $request, Restaurant $restaurant)
    {


        $request->validate([
            'name' => 'required',
            'vacancies' => [],
            'vacancies_data' => [],
        ]);
        

        // return $request['vacancies_data'][1];

        $restaurant->update($request->all());

        $pivotData = [];
        foreach ($request['vacancies'] as $vacancyId) {
            $vacancyData = $request['vacancies_data'][$vacancyId];
            $pivotData[$vacancyId] = ['price_per_hour' => $vacancyData['price_per_hour']];
        }
        $restaurant->vacancies()->sync($pivotData);
        
        return new RestaurantResource($restaurant);
    }

    public function destroy(Restaurant $restaurant)
    {
        $restaurant->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}

