<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FeeItem;
use Illuminate\Http\Request;

class FeeItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data=FeeItem::with('fee_item_months')->all();
        return $data;
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
    public function show($id)
    {

        $data=FeeItem::with('fee_item_months')->where('id',$id)->first();
        return $data;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
