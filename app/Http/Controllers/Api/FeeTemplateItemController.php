<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeeTemplateItem\StoreFeeTemplateItemRequest;
use App\Http\Requests\FeeTemplateItem\UpdateFeeTemplateItemRequest;
use App\Http\Resources\FeeTemplateItem\FeeTemplateItemCollection;
use App\Http\Resources\FeeTemplateItem\FeeTemplateItemResource;
use App\Models\FeeTemplateItem;
use Illuminate\Http\Request;

class FeeTemplateItemController extends Controller
{
    protected $userLoader=['fee_head'];

    public function index(Request $request)
    {

        $message=[];

        if(!$request->has('fee_template_id')){
           array_push($message,'Please provide fee template');
        }

        if($message){
            return response()->json(
                [
                   'status'=>false,
                   'message' => $message
                ]
           , 400);
        }
        return new FeeTemplateItemCollection(
            FeeTemplateItem::with($this->userLoader)
            ->where('fee_template_id',$request->input('fee_template_id'))
            ->orderBy('sort_index','ASC')
            ->get());
    }


    /**
     * Store a newly created resource in storage.
     */
     public function store(StoreFeeTemplateItemRequest $request)
    {
       // dd($request->all());
        $data = $request->validated();

        $fee_template_item = FeeTemplateItem::create($data);
        return new FeeTemplateItemResource($fee_template_item->load($this->userLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        $fee_template_item= FeeTemplateItem::find($id);
        return new FeeTemplateItemResource($fee_template_item->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(UpdateFeeTemplateItemRequest $request, $id)
    {

        $data = $request->validated();
        $fee_template_item= FeeTemplateItem::find($id);
        $fee_template_item->update($data);
        return new FeeTemplateItemResource($fee_template_item->load($this->userLoader));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( FeeTemplateItem $fee_template_item)
    {
        $fee_template_item->delete();
        return response(null, 204);
    }
}
