<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeeItemMonth\StoreFeeItemMonthRequest;
use App\Http\Requests\FeeItemMonth\UpdateFeeItemMonthRequest;
use App\Http\Resources\FeeItemMonth\FeeItemMonthCollection;
use App\Http\Resources\FeeItemMonth\FeeItemMonthResource;
use App\Http\Facades\FeeItemMonthFacade;
use Illuminate\Http\Request;

class FeeItemMonthController extends Controller
{
    use HasAdvancedFilter;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new FeeItemMonthCollection(FeeItemMonthFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeItemMonthRequest $request)
    {
        $data = $request->validated();
        $feeItemMonth = FeeItemMonthFacade::create($data);
        return new FeeItemMonthResource($feeItemMonth);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $feeItemMonth = FeeItemMonthFacade::getById($id);
        if (!$feeItemMonth) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new FeeItemMonthResource($feeItemMonth);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeItemMonthRequest $request, int $id)
    {
        $data = $request->validated();
        $feeItemMonth = FeeItemMonthFacade::update($id, $data);
        return new FeeItemMonthResource($feeItemMonth);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = FeeItemMonthFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
