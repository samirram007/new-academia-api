<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExpenseGroup\ExpenseGroupCollection;
use App\Models\ExpenseGroup;
use Illuminate\Http\Request;

class ExpenseGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ExpenseGroupCollection(ExpenseGroup::all());
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
    public function show(ExpenseGroup $expenseGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExpenseGroup $expenseGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpenseGroup $expenseGroup)
    {
        //
    }
}
