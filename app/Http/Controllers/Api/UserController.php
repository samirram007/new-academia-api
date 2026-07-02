<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userLoader=['address','address.state','address.country', 'addresses', 'addresses.state','addresses.country','designation','department','profile_document','guardians'];
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
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        //  dd($data);
        $user = User::create($data);
       // dd($data,$user);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

        return new UserResource($user->load($this->userLoader));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response(null, 204);
    }
}
