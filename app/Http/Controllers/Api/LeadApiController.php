<?php

namespace App\Http\Controllers\Api;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\LeadResource;

class LeadApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lead::query();

        // return $request->input('archive');
    
        if ($request->has('archive')) {
            $archive = $request->input('archive');
            if ($archive == 1) {
                $query->where('is_archive', 1);
            } elseif ($archive == 0) {
                $query->where('is_archive', 0);
            }
        }

    
        $leads = $query->with(['vacancy:id,name', 'restaurant:id,name'])
                       ->orderByDesc('created_at')->get();;
    
        return LeadResource::collection($leads);
    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'birthday' => 'required|string',
            'phone' => 'required|string',
            'social' => 'nullable|string',
            'rest' => 'nullable|exists:restaurants,id',
            'vac' => 'nullable|exists:vacancies,id',
            'is_archive' => 'nullable|boolean',
        ]);

        $lead = new Lead();
        $lead->name = $request->name;
        $lead->surname = $request->surname;
        $lead->birthday = $request->birthday;
        $lead->phone = $request->phone;
        $lead->social = $request->social;
        $lead->restaurant_id = $request->rest;
        $lead->vacancy_id = $request->vac;
        $lead->is_archive = false;
        $lead->save();

        return response()->json([
            'message' => 'Lead created successfully',
            // 'lead' => $lead,
        ], 201);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return new LeadResource($lead);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $request->validate([
            'name' => 'required|string',
            'surname' => 'required|string',
            'birthday' => 'required|string',
            'phone' => 'required|string',
            'social' => 'nullable|string',
            'is_archive' => 'nullable|boolean',
        ]);
    
        $lead->name = $request->input('name');
        $lead->surname = $request->input('surname');
        $lead->birthday = $request->input('birthday');
        $lead->phone = $request->input('phone');
        $lead->social = $request->input('social');
        $lead->is_archive = $request->input('is_archive', false);
    
        $lead->save();

        return new LeadResource($lead);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        if($lead->is_archive == 0){
            $lead->is_archive = 1;
            $lead->save();
            return new LeadResource($lead);
        }
        $lead->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
