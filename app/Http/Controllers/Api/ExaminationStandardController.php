<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationStandard\ExaminationStandardStoreRequest;
use App\Http\Requests\ExaminationStandard\ExaminationStandardUpdateRequest;
use App\Http\Resources\ExaminationStandard\ExaminationStandardCollection;
use App\Http\Resources\ExaminationStandard\ExaminationStandardResource;
use App\Http\Services\ExaminationStandardService;
use App\Models\ExaminationStandard;
use Illuminate\Http\Request;

class ExaminationStandardController extends Controller
{
    public function index(Request $request)
    {
        $data = app(ExaminationStandardService::class)->getAll();
        return new ExaminationStandardCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationStandardStoreRequest $request)
    {
        $data = $request->validated();
        $standard = app(ExaminationStandardService::class)->create($data);
        return new ExaminationStandardResource($standard->load(app(ExaminationStandardService::class)->getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $examinationStandard = app(ExaminationStandardService::class)->getById($id);
        if (!$examinationStandard) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ExaminationStandardResource($examinationStandard->load(app(ExaminationStandardService::class)->getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationStandardUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $examinationStandard = app(ExaminationStandardService::class)->update($id, $data);
        return new ExaminationStandardResource($examinationStandard->load(app(ExaminationStandardService::class)->getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(ExaminationStandardService::class)->delete($id);
        return response(null,204);
    }
}
