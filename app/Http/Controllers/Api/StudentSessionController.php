<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentSession\StoreStudentSessionRequest;
use App\Http\Resources\StudentSession\StudentSessionCollection;
use App\Http\Resources\StudentSession\StudentSessionResource;
use App\Models\AcademicClass;
use App\Models\AcademicStandard;
use App\Models\StudentSession;
use App\Models\TransportUser;
use App\Models\User;
use Illuminate\Http\Request;

class StudentSessionController extends Controller
{
    protected $foreignLoader = ['student', 'student.profile_document',
    'academic_session', 'academic_class', 'academic_standard'];
    public function index(Request $request)
    {
        $message = [];

        if (!$request->has('campus_id')) {
            array_push($message, 'Please provide campus');
        }
        if (!$request->has('academic_session_id')) {
            array_push($message, 'Please provide academic session');
        }
       // dd($request->has('academic_class_id'));
        if ($message) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $message,
                ]
                , 400);
        }

        if ($request->has('academic_class_id')) {
            $studentSessions = StudentSession::with($this->foreignLoader)
                ->where('academic_session_id', $request->input('academic_session_id'))
                ->where('academic_class_id', $request->input('academic_class_id'))
                ->get();
            return new StudentSessionCollection($studentSessions);
        }
        $studentSessions = StudentSession::with($this->foreignLoader)
        ->where('academic_session_id', $request->input('academic_session_id'))
        ->get();
      // dd($studentSessions);
        return new StudentSessionCollection($studentSessions);

    }
    public function StudentSessionsByStudentId($student_id)
    {
        // dd($student_id);
        $studentSessions = StudentSession::with($this->foreignLoader)->where('student_id', $student_id)->get();
        return new StudentSessionCollection($studentSessions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentSessionRequest $request)
    {
        $data = $request->validated();
        $studentSessions = StudentSession::create($data);
        // dd($data,$user);
        return new StudentSessionResource($studentSessions->load($this->foreignLoader));
    }
    public function enrollment(Request $request)
    {
        //$data = $request->validated();
        $studentSessions = new StudentSession();
        $academic_class=AcademicClass::find($request->input('academic_class_id'));
        $studentSessions->student_id=$request->input('student_id');
        $studentSessions->academic_session_id=$request->input('academic_session_id');
        $studentSessions->academic_class_id=$request->input('academic_class_id');
        $studentSessions->academic_standard_id=$academic_class->academic_standard_id;
        $studentSessions->campus_id=$request->input('campus_id');
        $studentSessions->section_id=$request->input('section_id');
        $studentSessions->roll_no=$request->input('roll_no');
        $studentSessions->status=$request->input('status');
        $studentSessions->save();
        if($request->input('status')==1){
            $user=User::where('id',$request->input('student_id'))->first();
            $user->academic_session_id=$request->input('academic_session_id');
            $user->admission_no=$request->input('admission_no');
            $user->admission_date=$request->input('admission_date');
            $user->academic_class_id=$request->input('academic_class_id');
            $user->campus_id=$request->input('campus_id');
            $user->update();
        }
        $transportUser=TransportUser::where('user_id',$request->input('student_id'))
        ->where('is_active',1)
        ->first();
        if($transportUser){
            $transportUser->student_session_id=$studentSessions->id;
            $transportUser->save();
        }
        return new StudentSessionResource($studentSessions->load($this->foreignLoader));
    }
    public function enrollmentUpdate(Request $request,$id)
    {
        //$data = $request->validated();
        $studentSessions = StudentSession::find($id);
        $academic_class=AcademicClass::find($request->input('academic_class_id'));
        $studentSessions->student_id=$request->input('student_id');
        $studentSessions->academic_session_id=$request->input('academic_session_id');
        $studentSessions->academic_class_id=$request->input('academic_class_id');
        $studentSessions->academic_standard_id=$academic_class->academic_standard_id;
        $studentSessions->campus_id=$request->input('campus_id');
        $studentSessions->section_id=$request->input('section_id');
        $studentSessions->roll_no=$request->input('roll_no');
        $studentSessions->status=$request->input('status');
        $studentSessions->save();
        if($request->input('status')==1){
            $user=User::where('id',$request->input('student_id'))->first();
            $user->academic_session_id=$request->input('academic_session_id');
            $user->admission_no=$request->input('admission_no');
            $user->admission_date=$request->input('admission_date');
            $user->academic_class_id=$request->input('academic_class_id');
            $user->campus_id=$request->input('campus_id');
            $user->update();
        }
        $transportUser=TransportUser::where('user_id',$request->input('student_id'))
        ->where('is_active',1)
        ->first();
        if($transportUser){
            $transportUser->student_session_id=$studentSessions->id;
            $transportUser->save();
        }
        // dd($data,$user);
        return new StudentSessionResource($studentSessions->load($this->foreignLoader));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $loader = array_merge($this->foreignLoader, ['student.guardians', 'student.addresses', 'student.address']);

        $studentSession = StudentSession::with($loader)->latest()->find($id);
        return new StudentSessionResource($studentSession);
    }
    public function generate_roll_no(Request $request)
    {

        $academic_session_id=$request->input('academic_session_id');
        $academic_class_id=$request->input('academic_class_id');
        $campus_id=$request->input('campus_id');
        $section_id=$request->input('section_id');
        $getLastRollNo=StudentSession::where('academic_session_id', $academic_session_id)
        ->where('academic_class_id', $academic_class_id)
        ->where('campus_id', $campus_id)
        ->where('section_id', $section_id)
        ->latest('roll_no')
        ->first();

        if($getLastRollNo)
        {
            $roll_no=$getLastRollNo->roll_no+1;
        }
        else
        {
            $roll_no=1;
        }
        return response()->json(['roll_no'=>$roll_no],200);

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
