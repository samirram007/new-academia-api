<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicClass\StoreAcademicClassRequest;
use App\Http\Requests\AcademicClass\UpdateAcademicClassRequest;
use App\Http\Resources\AcademicClass\AcademicClassCollection;
use App\Http\Resources\AcademicClass\AcademicClassResource;
use App\Models\AcademicClass;
use App\Models\Fee;
use App\Models\FeeTemplate;
use App\Models\StudentSession;
use App\Models\User;
use Illuminate\Http\Request;

class AcademicClassController extends Controller
{
    protected $userLoader = ['campus', 'academic_standard'];
    public function index(Request $request)
    {
        $message = [];

        // if(!$request->has('campus_id')){
        //     array_push($message,'Please provide campus_id');
        // }
        // if($message){
        //     return response()->json(
        //         [
        //            'status'=>false,
        //            'message' => $message
        //         ]
        //    , 400);
        // }
        $data = AcademicClass::with($this->userLoader)->orderBy('campus_id', 'asc')->get();
        // ->whereIn('academic_standard_id', function ($query) use ($request) {
        //     $query->select('id')
        //         ->from('academic_standards')
        //         ->orderBy('id', 'asc');
        // })->get();
        return new AcademicClassCollection($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAcademicClassRequest $request)
    {
        $data = $request->validated();
        $academicClass = AcademicClass::create($data);
        return new AcademicClassResource($academicClass);
    }

    /**
     * Display the specified resource.
     */
    public function show(AcademicClass $academicClass)
    {
        return new AcademicClassResource($academicClass);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAcademicClassRequest $request, AcademicClass $academicClass)
    {
        try {

            $result = \DB::transaction(function () use ($request, $academicClass) {
                $data = $request->validated();
                if($data['campus_id']==$academicClass->campus_id){
                    $academicClass->update($data);
                    return $academicClass;
                }
                $student_sessions=StudentSession::where('academic_class_id',$academicClass->id)->get();
                $student_sessions->each->update(['campus_id' => $data['campus_id']]);

                $fees=Fee::where('academic_class_id',$academicClass->id)->get();
                $fees->each->update(['campus_id' => $data['campus_id']]);

                $users=User::where('academic_class_id',$academicClass->id)->get();
                $users->each->update(['campus_id' => $data['campus_id']]);

                $fee_templates=FeeTemplate::where('academic_class_id',$academicClass->id)->get();
                $fee_templates->each->update(['campus_id' => $data['campus_id']]);

                $academicClass->update($data);
                return $academicClass;

            });

            return new AcademicClassResource($result);

        } catch (\Exception $e) {
            // If any exception occurs, transaction will be rolled back
            return response()->json([
                'success' => false,
                'message' => 'Error occurred: ' . $e->getMessage(),
            ], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AcademicClass $academicClass)
    {
        $academicClass->delete();
        return response(null, 204);
    }
}
