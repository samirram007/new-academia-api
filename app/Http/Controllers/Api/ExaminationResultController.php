<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationResult\ExaminationResultStoreRequest;
use App\Http\Requests\ExaminationResult\ExaminationResultUpdateRequest;
use App\Http\Resources\ExaminationResult\ExaminationResultCollection;
use App\Http\Resources\ExaminationResult\ExaminationResultResource;
use App\Http\Services\ExaminationResultService;
use App\Models\ExaminationResult;
use Illuminate\Http\Request;

class ExaminationResultController extends Controller
{
    public function index(Request $request)
    {
        $data = app(ExaminationResultService::class)->getAll();
        return new ExaminationResultCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationResultStoreRequest $request)
    {
        $data = $request->validated();
        $examination = app(ExaminationResultService::class)->create($data);
        return new ExaminationResultResource($examination->load(app(ExaminationResultService::class)->getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $examinationResult = app(ExaminationResultService::class)->getById($id);
        if (!$examinationResult) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ExaminationResultResource($examinationResult->load(app(ExaminationResultService::class)->getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationResultUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $examinationResult = app(ExaminationResultService::class)->update($id, $data);
        return new ExaminationResultResource($examinationResult->load(app(ExaminationResultService::class)->getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(ExaminationResultService::class)->delete($id);
        return response(null,204);
    }
}
