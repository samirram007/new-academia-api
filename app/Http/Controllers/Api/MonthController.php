<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Month\StoreMonthRequest;
use App\Http\Requests\Month\UpdateMonthRequest;
use App\Http\Resources\Month\MonthCollection;
use App\Http\Resources\Month\MonthResource;
use App\Http\Facades\MonthFacade;
use Illuminate\Http\Request;

class MonthController extends Controller
{
    use HasAdvancedFilter;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new MonthCollection(MonthFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMonthRequest $request)
    {
        $data = $request->validated();
        $month = MonthFacade::create($data);
        return new MonthResource($month);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $month = MonthFacade::getById($id);
        if (!$month) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new MonthResource($month);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMonthRequest $request, int $id)
    {
        $data = $request->validated();
        $month = MonthFacade::update($id, $data);
        return new MonthResource($month);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = MonthFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
