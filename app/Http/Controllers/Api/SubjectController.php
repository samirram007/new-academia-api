<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Subject\StoreSubjectRequest;
use App\Http\Requests\Subject\UpdateSubjectRequest;
use App\Http\Resources\Subject\SubjectCollection;
use App\Http\Resources\Subject\SubjectResource;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    protected $userLoader=['academic_standard','subject_group','logo_image'];
    public function index(Request $request)
    {
        $message=[];
        if(!$request->has('academic_standard_id')){
            array_push($message,'Please provide academic_standard_id');
        }
        if(!$request->has('subject_group_id')){
            array_push($message,'Please provide subject_group_id');
        }
        if($message){
            return response()->json(
                [
                   'status'=>false,
                   'message' => $message
                ]
           , 400);
        }
        return new SubjectCollection(Subject::with($this->userLoader)
        ->where('academic_standard_id',$request->input('academic_standard_id'))
        ->where('subject_group_id',$request->input('subject_group_id'))
        ->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubjectRequest $request)
    {

        $data = $request->validated();
        $subject = Subject::create($data);
        return new SubjectResource($subject->load($this->userLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {

        return new SubjectResource($subject->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {

        $data = $request->validated();
        $subject->update($data);
        return new SubjectResource($subject->load($this->userLoader));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();
        return response(null, 204);
    }
}
