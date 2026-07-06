<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\BookModuleFacade;
use App\Http\Requests\BookModule\StoreBookModuleRequest;
use App\Http\Requests\BookModule\UpdateBookModuleRequest;
use App\Http\Resources\BookModule\BookModuleCollection;
use App\Http\Resources\BookModule\BookModuleResource;

class BookModuleController extends Controller
{
    public function index()
    {
        return new BookModuleCollection(BookModuleFacade::getAll());
    }

    public function store(StoreBookModuleRequest $request)
    {
        $data = $request->validated();
        $model = BookModuleFacade::create($data);
        return new BookModuleResource($model);
    }

    public function show(int $id)
    {
        $model = BookModuleFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new BookModuleResource($model);
    }

    public function update(UpdateBookModuleRequest $request, int $id)
    {
        $data = $request->validated();
        $model = BookModuleFacade::update($id, $data);
        return new BookModuleResource($model);
    }

    public function destroy(int $id)
    {
        $response = BookModuleFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
