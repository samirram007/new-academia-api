<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExaminationStandard\ExaminationStandardStoreRequest;
use App\Http\Requests\ExaminationStandard\ExaminationStandardUpdateRequest;
use App\Http\Resources\ExaminationStandard\ExaminationStandardCollection;
use App\Http\Resources\ExaminationStandard\ExaminationStandardResource;
use App\Models\ExaminationStandard;
use Illuminate\Http\Request;

class ExaminationStandardController extends Controller
{

    protected $userLoader = ['academic_standard','examination'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ExaminationStandardCollection(ExaminationStandard::with($this->userLoader)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationStandardStoreRequest $examinationStandardStoreRequest)
    {
        $data = $examinationStandardStoreRequest->validated();
        $standard = ExaminationStandard::create($data);
        return new ExaminationStandardResource($standard->load($this->userLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show(ExaminationStandard $examinationStandard)
    {
        return new ExaminationStandardResource($examinationStandard->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationStandardUpdateRequest $examinationStandardStoreRequest, ExaminationStandard $examinationStandard)
    {
        $data = $examinationStandardStoreRequest->validated();
        $examinationStandard->update($data);
        return new ExaminationStandardResource($examinationStandard->load($this->userLoader));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExaminationStandard $examinationStandard)
    {
        $examinationStandard->delete();
        return response(null,204);
    }
}
