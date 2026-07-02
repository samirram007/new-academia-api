<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Examination\ExaminationStoreRequest;
use App\Http\Requests\Examination\ExaminationUpdateRequest;
use App\Http\Resources\Examination\ExaminationCollection;
use App\Http\Resources\Examination\ExaminationResource;
use App\Models\Examination;
use Illuminate\Http\Request;

class ExaminationController extends Controller
{
    protected $userLoader = ['examination_type', 'academic_session'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ExaminationCollection(Examination::with($this->userLoader)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationStoreRequest $request)
    {
        $data = $request->validated();
        $examination = Examination::create($data);
        return new ExaminationResource($examination->load($this->userLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show(Examination $examination)
    {
        return new ExaminationResource($examination->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationUpdateRequest $examinationUpdateRequest, Examination $examination)
    {
        $data = $examinationUpdateRequest->validated();
        $examination->update($data);
        return new ExaminationResource($examination->load($this->userLoader));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Examination $examination)
    {
        $examination->delete();
        return response(null, 204);
    }
}
