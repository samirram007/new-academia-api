<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\EducationBoard\EducationBoardRequest;
use App\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\EducationBoard\EducationBoardCollection;
use App\Http\Resources\EducationBoard\EducationBoardResource;
use App\Http\Facades\EducationBoardFacade;
use App\Http\Services\EducationBoardService;
use Illuminate\Http\Request;

class EducationBoardController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {
        $data = app(EducationBoardService::class)->getAll();
        return new EducationBoardCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EducationBoardRequest $request)
    {
        $data = $request->validated();
        $educationBoard = EducationBoardFacade::create($data);
        return new EducationBoardResource($educationBoard->load(app(EducationBoardService::class)->getResource()));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $educationBoard = EducationBoardFacade::getById($id);
        if (!$educationBoard) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new EducationBoardResource($educationBoard->load(app(EducationBoardService::class)->getResource()));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EducationBoardRequest $request, int $id)
    {
        $data = $request->validated();
        $educationBoard = EducationBoardFacade::update($id, $data);
        return new EducationBoardResource($educationBoard->load(app(EducationBoardService::class)->getResource()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        EducationBoardFacade::delete($id);
        return response(null, 204);
    }
}
