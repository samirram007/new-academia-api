<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JourneyType\JourneyTypeCollection;
use App\Models\JourneyType;
use Illuminate\Http\Request;

class JourneyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new JourneyTypeCollection(JourneyType::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(JourneyType $transportFee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JourneyType $transportFee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JourneyType $transportFee)
    {
        //
    }
}
