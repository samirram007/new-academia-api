<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Facades\SharedDocumentFacade;
use App\Http\Resources\Share\ShareCollection;
use App\Http\Resources\Share\ShareResource;
use Illuminate\Http\Request;

class SharedDocumentController extends Controller
{
    public function index()
    {
        return new ShareCollection(SharedDocumentFacade::getAll());
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:255']);
        $model = SharedDocumentFacade::create($data);
        return new ShareResource($model);
    }

    public function show(int $id)
    {
        $model = SharedDocumentFacade::getById($id);
        if (!$model) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new ShareResource($model);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate(['name' => 'sometimes|string|max:255']);
        $model = SharedDocumentFacade::update($id, $data);
        return new ShareResource($model);
    }

    public function destroy(int $id)
    {
        $response = SharedDocumentFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
