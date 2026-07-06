<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Examination\ExaminationStoreRequest;
use App\Http\Requests\Examination\ExaminationUpdateRequest;
use App\Http\Resources\Examination\ExaminationCollection;
use App\Http\Resources\Examination\ExaminationResource;
use App\Http\Services\ExaminationService;
use App\Models\Examination;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    public function index(Request $request)
    {
        $data = app(ExaminationService::class)->getAll();
        return new ExaminationCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationStoreRequest $request)
    {
        $data = $request->validated();
        $examination = app(ExaminationService::class)->create($data);
        return new ExaminationResource($examination->load(app(ExaminationService::class)->getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $examination = app(ExaminationService::class)->getById($id);
        if (!$examination) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ExaminationResource($examination->load(app(ExaminationService::class)->getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $examination = app(ExaminationService::class)->update($id, $data);
        return new ExaminationResource($examination->load(app(ExaminationService::class)->getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(ExaminationService::class)->delete($id);
        return response(null, 204);
    }
}
