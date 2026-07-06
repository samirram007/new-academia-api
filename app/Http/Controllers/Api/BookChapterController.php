<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\BookChapterFacade;
use App\Http\Requests\BookChapter\StoreBookChapterRequest;
use App\Http\Requests\BookChapter\UpdateBookChapterRequest;
use App\Http\Resources\BookChapter\BookChapterCollection;
use App\Http\Resources\BookChapter\BookChapterResource;

class BookChapterController extends Controller
{
    public function index()
    {
        return new BookChapterCollection(BookChapterFacade::getAll());
    }

    public function store(StoreBookChapterRequest $request)
    {
        $data = $request->validated();
        $model = BookChapterFacade::create($data);
        return new BookChapterResource($model);
    }

    public function show(int $id)
    {
        $model = BookChapterFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new BookChapterResource($model);
    }

    public function update(UpdateBookChapterRequest $request, int $id)
    {
        $data = $request->validated();
        $model = BookChapterFacade::update($id, $data);
        return new BookChapterResource($model);
    }

    public function destroy(int $id)
    {
        $response = BookChapterFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
