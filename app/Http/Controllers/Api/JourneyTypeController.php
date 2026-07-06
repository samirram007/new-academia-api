<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\JourneyType\StoreJourneyTypeRequest;
use App\Http\Requests\JourneyType\UpdateJourneyTypeRequest;
use App\Http\Resources\JourneyType\JourneyTypeCollection;
use App\Http\Resources\JourneyType\JourneyTypeResource;
use App\Http\Facades\JourneyTypeFacade;
use Illuminate\Http\Request;

class JourneyTypeController extends Controller
{
    use HasAdvancedFilter;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new JourneyTypeCollection(JourneyTypeFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreJourneyTypeRequest $request)
    {
        $data = $request->validated();
        $journeyType = JourneyTypeFacade::create($data);
        return new JourneyTypeResource($journeyType);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $journeyType = JourneyTypeFacade::getById($id);
        if (!$journeyType) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new JourneyTypeResource($journeyType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJourneyTypeRequest $request, int $id)
    {
        $data = $request->validated();
        $journeyType = JourneyTypeFacade::update($id, $data);
        return new JourneyTypeResource($journeyType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = JourneyTypeFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
