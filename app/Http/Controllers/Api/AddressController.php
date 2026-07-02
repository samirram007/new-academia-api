<?php

namespace App\Http\Controllers\Api;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Address\AddressResource;
use App\Http\Resources\Address\AddressCollection;
use App\Http\Requests\Address\StoreAddressRequest;
use App\Http\Requests\Address\UpdateAddressRequest;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return new AddressCollection(Address::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAddressRequest $request)
    {
        $data = $request->validated();
        $address=Address::create($data);
        return new AddressResource($address);
    }

    /**
     * Display the specified resource.
     */
    public function show(Address $address)
    {

        return new AddressResource($address);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request,Address $address)
    {
        $data = $request->validated();
        $address->update($data);
        return new AddressResource($address);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Address $address)
    {
        $address->delete();
        return response(null, 204);
    }
}
