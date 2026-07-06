<?php

namespace App\Http\Controllers\Api;

use App\Traits\HasAdvancedFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreGuardianRequest;
use App\Http\Requests\User\UpdateGuardianRequest;
use App\Http\Resources\Guardian\GuardianCollection;
use App\Http\Resources\Guardian\GuardianResource;
use App\Http\Facades\GuardianFacade;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    use HasAdvancedFilter;

    public function index(Request $request)
    {
        return new GuardianCollection(GuardianFacade::getAll($request));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuardianRequest $request)
    {
        $data = $request->validated();
        $user = GuardianFacade::create($data);
        return new GuardianResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = GuardianFacade::getById($id);
        if (!$user) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return new GuardianResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuardianRequest $request, int $id)
    {
        $data = $request->validated();
        $user = GuardianFacade::update($id, $data);
        return new GuardianResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = GuardianFacade::delete($id);
        if (!$response) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response(null, 204);
    }
}
