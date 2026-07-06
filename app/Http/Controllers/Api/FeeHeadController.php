<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\FeeHeadService;
use App\Models\FeeHead;
use Illuminate\Http\Request;
use App\Http\Resources\FeeHead\FeeHeadResource;
use App\Http\Resources\FeeHead\FeeHeadCollection;
use App\Http\Requests\FeeHead\StoreFeeHeadRequest;
use App\Http\Requests\FeeHead\UpdateFeeHeadRequest;

class FeeHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = app(FeeHeadService::class)->getAll();
        return new FeeHeadCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeHeadRequest $request)
    {
        $data = $request->validated();
        $fee_head = app(FeeHeadService::class)->create($data);
        return new FeeHeadResource($fee_head);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $fee_head = app(FeeHeadService::class)->getById($id);
        if (!$fee_head) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new FeeHeadResource($fee_head);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeHeadRequest $request, int $id)
    {
        $data = $request->validated();
        $fee_head = app(FeeHeadService::class)->update($id, $data);
        return new FeeHeadResource($fee_head);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(FeeHeadService::class)->delete($id);
        return response(null, 204);
    }
}
