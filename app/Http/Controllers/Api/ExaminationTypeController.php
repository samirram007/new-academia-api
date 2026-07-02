<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        return new ExaminationTypeCollection(ExaminationType::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExaminationTypeStoreRequest $request)
    {
        $data = $request->validated();
        $examination = ExaminationType::create($data);
        return new ExaminationTypeResource($examination);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return new ExaminationTypeResource(ExaminationType::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExaminationTypeUpdateRequest $request, ExaminationType $examinationType)
    {
        $data = $request->validated();
        $examinationType->update($data);
        return new ExaminationTypeResource($examinationType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = ExaminationType::findOrFail($id);

        if (!empty($data)) {
            $data->delete();
            return response(null, 204);
        }
    }
}
