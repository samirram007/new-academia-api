<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\FeeItem\StoreFeeItemRequest;
use App\Http\Requests\FeeItem\UpdateFeeItemRequest;
use App\Http\Resources\FeeItem\FeeItemCollection;
use App\Http\Resources\FeeItem\FeeItemResource;
use App\Http\Facades\FeeItemFacade;
use Illuminate\Http\Request;

class FeeItemController extends Controller
{
    use HasAdvancedFilter;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new FeeItemCollection(FeeItemFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeItemRequest $request)
    {
        $data = $request->validated();
        $feeItem = FeeItemFacade::create($data);
        return new FeeItemResource($feeItem);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $feeItem = FeeItemFacade::getById($id);
        if (!$feeItem) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new FeeItemResource($feeItem);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeItemRequest $request, int $id)
    {
        $data = $request->validated();
        $feeItem = FeeItemFacade::update($id, $data);
        return new FeeItemResource($feeItem);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = FeeItemFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
