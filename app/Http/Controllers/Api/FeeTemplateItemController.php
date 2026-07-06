<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeTemplateItem\StoreFeeTemplateItemRequest;
use App\Http\Requests\FeeTemplateItem\UpdateFeeTemplateItemRequest;
use App\Http\Resources\FeeTemplateItem\FeeTemplateItemCollection;
use App\Http\Resources\FeeTemplateItem\FeeTemplateItemResource;
use App\Http\Services\FeeTemplateItemService;
use App\Models\FeeTemplateItem;
use Illuminate\Http\Request;

class FeeTemplateItemController extends Controller
{
    public function index(Request $request)
    {
        $data = app(FeeTemplateItemService::class)->getAll();
        return new FeeTemplateItemCollection($data);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeTemplateItemRequest $request)
    {
        $data = $request->validated();
        $fee_template_item = app(FeeTemplateItemService::class)->create($data);
        return new FeeTemplateItemResource($fee_template_item->load(app(FeeTemplateItemService::class)->getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $fee_template_item = app(FeeTemplateItemService::class)->getById($id);
        if (!$fee_template_item) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new FeeTemplateItemResource($fee_template_item->load(app(FeeTemplateItemService::class)->getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeTemplateItemRequest $request, int $id)
    {
        $data = $request->validated();
        $fee_template_item = app(FeeTemplateItemService::class)->update($id, $data);
        return new FeeTemplateItemResource($fee_template_item->load(app(FeeTemplateItemService::class)->getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(FeeTemplateItemService::class)->delete($id);
        return response(null, 204);
    }
}
