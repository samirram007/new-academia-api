<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\SectionService;
use App\Http\Requests\Section\SectionRequest;
use App\Http\Resources\Section\SectionCollection;
use App\Http\Resources\Section\SectionResource;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = app(SectionService::class)->getAll();
        return new SectionCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request)
    {
        $data = $request->validated();
        $section = app(SectionService::class)->create($data);
        return new SectionResource($section);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $section = app(SectionService::class)->getById($id);
        if (!$section) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new SectionResource($section);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request, int $id)
    {
        $data = $request->validated();
        $section = app(SectionService::class)->update($id, $data);
        return new SectionResource($section);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        app(SectionService::class)->delete($id);
        return response(null, 204);
    }
}
