<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use App\Models\Vacancy;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Http\Resources\VacancyResource;
use App\Http\Resources\RestaurantResource;
use App\Http\Controllers\Api\MediaController;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function view()
    {

        $page = Page::findorFail(1);
        $page_data = new PageResource($page);
        $restaurants = RestaurantResource::collection(Restaurant::with('vacancies')->get());
        $vacancies = VacancyResource::collection(Vacancy::all());

        $data = ['page' => $page_data, 'restaurants' => $restaurants, 'vacancies' => $vacancies];

        // return $data;

        return view('landing')->with('data', $data);
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
    public function show(Page $page)
    {   
        return new PageResource($page);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'phone' => 'required',
            'email' => 'required',
            'about' =>  'required',
            'questions' => 'required',
        ]);
        $data = [
            'phone' => $request['phone'],
            'email' => $request['email'],
            'about' => $request['about'],
            'questions' => json_encode($request['questions']),
        ];
        
        $page->update($data);
        
        (new MediaController)->syncMedia($request->input('images_slider', []), $page->id);
        (new MediaController)->syncMedia($request->input('images_benefits', []), $page->id);

        return new PageResource($page);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeMedia(Request $request, $collection_name)
    {
        $model = new Page();
        return  (new MediaController)->storeMedia($request, $model, $collection_name);
    }
}
