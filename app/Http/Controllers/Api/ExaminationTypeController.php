<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\ExaminationTypeService;
use Illuminate\Http\Request;
use App\Http\Requests\ExaminationType\ExaminationTypeStoreRequest;
use App\Http\Requests\ExaminationType\ExaminationTypeUpdateRequest;
use App\Models\ExaminationType;
use App\Http\Resources\ExaminationType\ExaminationTypeResource;
use App\Http\Resources\ExaminationType\ExaminationTypeCollection;

class ExaminationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = app(ExaminationTypeService::class)->getAll();
        return new ExaminationTypeCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationTypeStoreRequest $request)
    {
        $data = $request->validated();
        $examination = app(ExaminationTypeService::class)->create($data);
        return new ExaminationTypeResource($examination);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $examinationType = app(ExaminationTypeService::class)->getById($id);
        if (!$examinationType) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ExaminationTypeResource($examinationType);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationTypeUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $examinationType = app(ExaminationTypeService::class)->update($id, $data);
        return new ExaminationTypeResource($examinationType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(ExaminationTypeService::class)->delete($id);
        return response(null, 204);
    }
}
