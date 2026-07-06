<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\IncomeGroupService;
use App\Http\Resources\IncomeGroup\IncomeGroupCollection;
use App\Models\IncomeGroup;
use Illuminate\Http\Request;

class IncomeGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = app(IncomeGroupService::class)->getAll();
        return new IncomeGroupCollection($data);
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
    public function show(IncomeGroup $incomeGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncomeGroup $incomeGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomeGroup $incomeGroup)
    {
        //
    }
}
