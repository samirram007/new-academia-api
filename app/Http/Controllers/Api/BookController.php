<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\BookFacade;
use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\Book\BookCollection;
use App\Http\Resources\Book\BookResource;

class BookController extends Controller
{
    public function index()
    {
        return new BookCollection(BookFacade::getAll());
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();
        $model = BookFacade::create($data);
        return new BookResource($model);
    }

    public function show(int $id)
    {
        $model = BookFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new BookResource($model);
    }

    public function update(UpdateBookRequest $request, int $id)
    {
        $data = $request->validated();
        $model = BookFacade::update($id, $data);
        return new BookResource($model);
    }

    public function destroy(int $id)
    {
        $response = BookFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
