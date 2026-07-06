<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\AddressService;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressCollection;
use App\Http\Requests\Address\AddressRequest;
use App\Http\Facades\AddressFacade;

use JsonSerializable;

class AddressController extends Controller
{
    use ApiResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonSerializable
    {
        $data = app(AddressService::class)->getAll();
        return new AddressCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddressRequest $request)
    {
        $data = $request->validated();
        $address = AddressFacade::create($data);
        return new AddressResource($address);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $address = AddressFacade::getById($id);
        if (!$address) {
            return $this->errorResponse('Address not found', 404);
        }
        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AddressRequest $request, int $id)
    {
        $data = $request->validated();
        $address = AddressFacade::update($id, $data);
        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $response = AddressFacade::delete($id);
        if (!$response) {
            return $this->errorResponse('Address not found', 404);
        }
        return response(null, 204);
    }
}
