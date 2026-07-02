<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Section\StoreSectionRequest;
use App\Http\Requests\Section\UpdateSectionRequest;
use App\Http\Resources\Section\SectionCollection;
use App\Http\Resources\Section\SectionResource;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return new SectionCollection(Section::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request)
    {

        $data = $request->validated();
        $section = Section::create($data);
        return new SectionResource($section);
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {

        return new SectionResource($section);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {

        $data = $request->validated();
        $section->update($data);
        return new SectionResource($section);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return response(null, 204);
    }
}
