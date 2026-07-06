<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationSchedule\ExaminationScheduleStoreRequest;
use App\Http\Requests\ExaminationSchedule\ExaminationScheduleUpdateRequest;
use App\Http\Resources\ExaminationSchedule\ExaminationScheduleCollection;
use App\Http\Resources\ExaminationSchedule\ExaminationScheduleResource;
use App\Http\Services\ExaminationScheduleService;
use App\Models\ExaminationSchedule;
use Illuminate\Http\Request;

class ExaminationScheduleController extends Controller
{
    public function index(Request $request)
    {
        $data = app(ExaminationScheduleService::class)->getAll();
        return new ExaminationScheduleCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationScheduleStoreRequest $request)
    {
        $data = $request->validated();
        $examination = app(ExaminationScheduleService::class)->create($data);
        return new ExaminationScheduleResource($examination->load(app(ExaminationScheduleService::class)->getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $examinationSchedule = app(ExaminationScheduleService::class)->getById($id);
        if (!$examinationSchedule) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ExaminationScheduleResource($examinationSchedule->load(app(ExaminationScheduleService::class)->getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationScheduleUpdateRequest $request, int $id)
    {
        $data = $request->validated();
        $examinationSchedule = app(ExaminationScheduleService::class)->update($id, $data);
        return new ExaminationScheduleResource($examinationSchedule->load(app(ExaminationScheduleService::class)->getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(ExaminationScheduleService::class)->delete($id);
        return response(null,204);
    }
}
