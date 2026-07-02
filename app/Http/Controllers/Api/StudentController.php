<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreStudentRequest;
use App\Http\Requests\User\UpdateStudentRequest;
use App\Http\Resources\Student\StudentCollection;
use App\Http\Resources\Student\StudentResource;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
        protected $userLoader;
        function __construct()
        {

            $this->userLoader= [
                'academic_session',
                'academic_class',
                'campus',
                'addresses' => function ($query) {
                    $query->with(['state', 'country']);
                },
                'designation',
                'department',
                'profile_document',
                'guardians'=> function ($query) {
                    $query-> where('guardian_type', '!=',null)
                    ->where('user_type','=','guardian');
                },
                'student_sessions' => function ($query) {
                    $query->  where('academic_session_id', '!=', 0)
                    ->  where('academic_session_id', '!=',null)
                    ->with([
                        'campus',
                        'academic_class',
                        'academic_session' ,
                        'section',
                        'fee_item_months' => function ($query) {
                            $query->where('is_deleted', '!=', 1)
                                  ->with(['month']);
                        }
                    ]);
                }
            ];
        }
        protected $foreignLoader = ['student', 'student.profile_document', 'academic_session', 'academic_class', 'academic_standard'];

    public function index(Request $request)
    {
        $message = [];

        if (!$request->has('filter_option')) {
            array_push($message, 'Please provide filter option');
        }


        if ($request->input('filter_option') == 'active') {

            if (!$request->has('academic_session_id')) {
                array_push($message, 'Please provide academic session');
            }
            if (!$request->has('academic_class_id')) {
                array_push($message, 'Please provide academic class');
            }
            if ($message) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $message,
                    ]
                    , 400);
            }

            $users = User::with($this->userLoader)
                ->where('user_type', 'student')
                ->whereIn('id', function ($query) use ($request) {
                    $query->select('student_id')
                        ->from('student_sessions')
                        ->whereIn('academic_session_id', [$request->input('academic_session_id')])
                        ->whereIn('academic_class_id', [$request->input('academic_class_id')]);
                })->get();
            return new StudentCollection($users);
        } elseif ($request->input('filter_option') == 'admission') {
           // dd($request->all());
            if ($request->has('academic_session_id') && $request->has('academic_class_id')) {

                $users = User::with($this->userLoader)
                    ->where('user_type', 'student')
                    ->where('academic_session_id', $request->input('academic_session_id'))
                    ->where('academic_class_id', $request->input('academic_class_id'))
                    ->whereNotIn('id', function ($query) use ($request) {
                        $query->select('student_id')
                            ->from('student_sessions') ;
                    })->get();
                return new StudentCollection($users);
            }
            if ($request->has('academic_session_id') ) {
                $users = User::with($this->userLoader)
                    ->where('user_type', 'student')
                    ->where('academic_session_id', $request->input('academic_session_id'))
                    ->whereNotIn('id', function ($query) use ($request) {
                        $query->select('student_id')
                            ->from('student_sessions') ;
                    })->get();
                return new StudentCollection($users);
            }
            $users = User::with($this->userLoader)
                ->where('user_type', 'student')
                ->whereNotIn('id', function ($query) use ($request) {
                    $query->select('student_id')
                        ->from('student_sessions')
                        ->where('academic_session_id','!=',0)
                        ->where('academic_session_id','!=',null);
                })->get();
            return new StudentCollection($users);
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => "Please select Filter Option",
                ]
                , 400);
        }

        // return new StudentCollection(
        //     $request->per_page
        //     ? User::with($this->userLoader)
        //     ->where('user_type',$request->has('user_type') ? $request->user_type:true)->paginate($request->per_page)
        //     : User::with($this->userLoader)
        //     ->where('user_type',$request->has('user_type') ? $request->user_type:true)
        //     ->get()
        // );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();
        //  dd($data);
        $user = User::create($data);
        // dd($data,$user);
        return new StudentResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        return new StudentResource($user->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, $id)
    {

        $data = $request->validated();
        $user = User::find($id);
        $user->update($data);
        return new StudentResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}