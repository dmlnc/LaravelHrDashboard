<?php

namespace App\Http\Controllers\Api;

use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\VacancyResource;
use App\Http\Controllers\Api\MediaController;

class VacancyApiController extends Controller
{
    public function index()
    {
        return VacancyResource::collection(Vacancy::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $vacancy = Vacancy::create($request->all());

        (new MediaController)->syncMedia($request->input('images', []), $vacancy->id);

        return new VacancyResource($vacancy);
    }

    public function show(Vacancy $vacancy)
    {
        return new VacancyResource($vacancy);
    }

    public function update(Request $request, Vacancy $vacancy)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $vacancy->update($request->all());
        
        (new MediaController)->syncMedia($request->input('images', []), $vacancy->id);

        return new VacancyResource($vacancy);
    }

    public function destroy(Vacancy $vacancy)
    {
        $vacancy->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeMedia(Request $request)
    {
        $model = new Vacancy();
        return  (new MediaController)->storeMedia($request, $model, 'vacancy_image');
    }
}
