<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeTemplate\StoreFeeTemplateRequest;
use App\Http\Requests\FeeTemplate\UpdateFeeTemplateRequest;
use App\Http\Resources\FeeTemplate\FeeTemplateCollection;
use App\Http\Resources\FeeTemplate\FeeTemplateResource;
use App\Http\Services\FeeTemplateService;
use App\Models\FeeTemplate;
use Illuminate\Http\Request;

class FeeTemplateController extends Controller
{
    public function index(Request $request)
    {
        $data = app(FeeTemplateService::class)->getAll();
        return new FeeTemplateCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFeeTemplateRequest $request)
    {
        $data = $request->validated();
        $fee_template = app(FeeTemplateService::class)->create($data);
        return new FeeTemplateResource($fee_template);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $fee_template = app(FeeTemplateService::class)->getById($id);
        if (!$fee_template) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new FeeTemplateResource($fee_template);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFeeTemplateRequest $request, int $id)
    {
        $data = $request->validated();
        $fee_template = app(FeeTemplateService::class)->update($id, $data);
        return new FeeTemplateResource($fee_template);
    }
    public function clone(StoreFeeTemplateRequest $request, $id)
    {
        $existing_fee_template = app(FeeTemplateService::class)->getById($id);

        $data = $request->validated();
        $fee_template = app(FeeTemplateService::class)->create($data);

        $fee_template->fee_template_items()->createMany($existing_fee_template->fee_template_items()->get()->toArray());
        return new FeeTemplateResource($fee_template);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(FeeTemplateService::class)->delete($id);
        return response(null, 204);
    }
}
