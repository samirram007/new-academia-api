<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreGuardianRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateGuardianRequest;
use App\Http\Resources\Guardian\GuardianResource;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\StudentGuardian;
use App\Models\User;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    protected $userLoader=['designation','department','profile_document'];
    public function index(Request $request)
    {
        //dd($request->has('user_type') );
        //$request->has('user_type') && $request->role === 'admin'? $this->userLoader[]='roles' : null;

        return new UserCollection(
            $request->per_page
            ? User::with($this->userLoader)
            ->where('user_type',$request->has('user_type') ? $request->user_type:true)->paginate($request->per_page)
            : User::with($this->userLoader)
            ->where('user_type',$request->has('user_type') ? $request->user_type:true)
            ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuardianRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);
        if($user){
            $studentGuardian= new StudentGuardian();
            $studentGuardian->guardian_id=$user->id;
            $studentGuardian->student_id=$request->student_id;
            $studentGuardian->save();
        }
       // dd($data,$user);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGuardianRequest $request, $id)
    {

        $data = $request->validated();
        $user = User::find($id);
        $user->update($data);
        return new GuardianResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}