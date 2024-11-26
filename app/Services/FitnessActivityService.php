<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\FitnessActivity;
use App\Models\Activities\Cycling;
use App\Models\Activities\Running;
use App\Models\Activities\Force;
use App\Services\SearchService;

class FitnessActivityService
{
    private $activities = [
        'cycling'   => [
            'title' => "Cycling",
            'class' =>  Cycling::class,
        ],
        'running'   => [
            'title' => "Running",
            'class' =>  Running::class,
        ],
        'force'     => [
            'title' => "Force",
            'class' =>  Force::class,
        ],
    ];

    public function getActivityByType(string $type) 
    {
        
        if (!array_key_exists($type, $this->activities)) {
            throw new \Exception("This activity is not valid", 1);
        }

        return $this->activities[$type]['class'];
    }

    public function userActivities() {
        return FitnessActivity::where('user_id', \Auth::user()->id)->get();
    }

    public function createActivity(Request $request)
    {
        $validator =  \Validator::make($request->all(),[
            'activity_type' => 'required|string',
            'activity_date' => 'required|date',
            'name' => 'required|string|max:255',
        ]);

        if($validator->fails()) 
        {
            throw new \Exception(sprintf("Validation Error: %s", $validator->errors()) , 1);
        }
        
        $class = $this->getActivityByType($request->input("activity_type"));

        // Validate if type is a valid subclass
        if (!class_exists($class) || !is_subclass_of($class, FitnessActivity::class)) {
            dd(!is_subclass_of($activityInstance, FitnessActivity::class));
            throw \Illuminate\Validation\ValidationException::withMessages([
                'activity_type' => ['Invalid activity type provided.']
            ]);
        }

        $activityInstance = new $class;
        
        $rules = $activityInstance->validProperties();

        $validatedSpecific =  \Validator::make($request->all(), $rules);

        if($validatedSpecific->fails()) 
        {
            throw new \Exception(sprintf("Validation Error: %s", $validatedSpecific->errors()) , 1);
        }

        $values = $activityInstance->completeValues($activityInstance, $request->all());
        // dd();
        return FitnessActivity::create($values->toArray() );
    }

    public function search(Request $request, SearchService $searchService)
    {
        $params = $request->all();

        // Initial query
        $query = FitnessActivity::query();

        // Apply dynamic filter
        $query = $searchService->buildDynamicQuery($query, $params);

        // Execute the query
        $results = $query->get();

        // Get pagination details
        $totalCount = FitnessActivity::count();
        $startCursor = $results->first()?->id;
        $endCursor = $results->last()?->id;
        $hasNextPage = $params['first'] ?? false;
        $hasPreviousPage = $params['last'] ?? false;

        $nodes = $searchService->buildDynamicResponse($results, $totalCount, $startCursor, $endCursor, $hasNextPage, $hasPreviousPage);

        return $nodes;
    }

    public function analytics(SearchService $searchService, $activity_type, $property, $aggregation)
    {
        $query = FitnessActivity::query();

        $result =  $query->selectRaw("$aggregation(JSON_EXTRACT(properties, '$.$property')) as result")
            ->where('user_id', \Auth::user()->id)
            ->where('activity_type', $activity_type)
            ->value('result');
            
        return [
            'property' => $property,
            'aggregation' => $aggregation,
            'result' => $result,
        ];
    }
}