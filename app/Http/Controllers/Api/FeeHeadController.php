<?php

namespace App\Http\Controllers\Api;

use App\Models\FeeHead;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeeHead\FeeHeadResource;
use App\Http\Resources\FeeHead\FeeHeadCollection;
use App\Http\Requests\FeeHead\StoreFeeHeadRequest;
use App\Http\Requests\FeeHead\UpdateFeeHeadRequest;

class FeeHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new FeeHeadCollection(FeeHead::with(['income_group'])->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeHeadRequest $request)
    {
        $data = $request->validated();
        $fee_head = FeeHead::create($data);
        return new FeeHeadResource($fee_head);
    }

    /**
     * Display the specified resource.
     */
    public function show(FeeHead $fee_head)
    {
        return new FeeHeadResource($fee_head);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeHeadRequest $request, FeeHead $fee_head)
    {

        $data = $request->validated();
        $fee_head->update($data);
        return new FeeHeadResource($fee_head);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( FeeHead $fee_head)
    {
        $fee_head->delete();
        return response(null, 204);
    }
}
