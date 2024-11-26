<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FitnessActivity;
use App\Services\FitnessActivityService;
use App\Services\SearchService;

class FitnessActivityController extends Controller
{
    protected $fitnessActivityService;
    protected $searchService;

    public function __construct(FitnessActivityService $fitnessActivityService, SearchService $searchService)
    {
        $this->fitnessActivityService = $fitnessActivityService;
        $this->searchService = $searchService;
    }

    public function index()
    {
        try {
            $userActivities = $this->fitnessActivityService->userActivities();
            return response()->json($userActivities, 201);
        } catch (\Throwable $th) {
            return response()->json([
                "error" => 'validation_error',
                "message" => $th->message,
            ], 422);
        }
      
    }

    public function store(Request $request)
    {
        $activity = $this->fitnessActivityService->createActivity($request);
        return response()->json($activity, 201);
    }

    public function search(Request $request) 
    {
        $response = $this->fitnessActivityService->search($request, $this->searchService);
        return response()->json($response, 201);
    }

    public function analytics(Request $request, $activity_type, $property, $aggregation)
    {
        $response = $this->fitnessActivityService->analytics($this->searchService, $activity_type, $property, $aggregation);
        return response()->json($response, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
