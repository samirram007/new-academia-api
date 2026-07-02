<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationResult\ExaminationResultStoreRequest;
use App\Http\Requests\ExaminationResult\ExaminationResultUpdateRequest;
use App\Http\Resources\ExaminationResult\ExaminationResultCollection;
use App\Http\Resources\ExaminationResult\ExaminationResultResource;
use App\Http\Resources\ExaminationResult\ExaminationResultShowCollection;
use App\Models\ExaminationResult;

class ExaminationResultController extends Controller
{
    protected $userLoader = ['examination_scheduled','student'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ExaminationResultCollection(ExaminationResult::with($this->userLoader)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationResultStoreRequest $examinationResultStoreRequest)
    {
        $data = $examinationResultStoreRequest->validated();
        $examination = ExaminationResult::create($data);
        return new ExaminationResultResource($examination->load($this->userLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show(ExaminationResult $examinationResult)
    {
        return new ExaminationResultResource($examinationResult->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationResultUpdateRequest $examinationResultUpdateRequest, ExaminationResult $examinationResult)
    {
        $data = $examinationResultUpdateRequest->validated();
        $examinationResult->update($data);
        return new ExaminationResultResource($examinationResult->load($this->userLoader));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExaminationResult $examinationResult)
    {
        $examinationResult->delete();
        return response(null,204);
    }
}
