<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationSchedule\ExaminationScheduleStoreRequest;
use App\Http\Requests\ExaminationSchedule\ExaminationScheduleUpdateRequest;
use App\Http\Resources\ExaminationSchedule\ExaminationScheduleCollection;
use App\Http\Resources\ExaminationSchedule\ExaminationScheduleResource;
use App\Models\ExaminationSchedule;
use Illuminate\Http\Request;

class ExaminationScheduleController extends Controller
{
    protected $userLoader = ['examination_standard','subject','teacher'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ExaminationScheduleCollection(ExaminationSchedule::with($this->userLoader)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationScheduleStoreRequest $examinationScheduleStoreRequest)
    {
        $data = $examinationScheduleStoreRequest->validated();
        $examination = ExaminationSchedule::create($data);
        return new ExaminationScheduleResource($examination->load($this->userLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show(ExaminationSchedule $examinationSchedule)
    {
        return new ExaminationScheduleResource($examinationSchedule->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationScheduleUpdateRequest $examinationScheduleUpdateRequest, ExaminationSchedule $examinationSchedule)
    {
        $data = $examinationScheduleUpdateRequest->validated();
        $examinationSchedule->update($data);
        return new ExaminationScheduleResource($examinationSchedule->load($this->userLoader));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExaminationSchedule $examinationSchedule)
    {
        $examinationSchedule->delete();
        return response(null,204);
    }
}
