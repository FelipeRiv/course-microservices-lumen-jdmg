<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
// use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
        
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return user list
     * @return list of users
     */
    public function index(){
        $users = User::all();

        return $this->validResponse($users);
        
    }

    /**
     * Create an instance of user
     * @return Illuminate\Http\Response
     */
    public function store(Request $request){

        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = Hash::make($request->password);

        $user = User::create($fields);

        return  $this->successResponse($user, Response::HTTP_CREATED);
    }

    /**
     * Return a specific user
     * @return Illuminate\Http\Response
     */
    public function show($user){
        $user = User::findOrFail($user);

        return $this->successResponse($user);
    }

    /**
     * Update a specific user
     * @return Illuminate\Http\Response
     */
    public function edit(){

    }

    /**
     * Update the information of an existing user
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, $user){

        /**
         * the email has to be a valid email and the field email from users table has to be unique except if the $user has the same email that already has
         * (( 'email|unique:users,email'. $user, )) .$user -> the concatenated $user means that is not going to fail if the user saves the same email that already had, it will only fail if the email is the same as someone elses email 
         */
        $rules = [
            'name' => 'max:255',
            'email' => 'email|unique:users,email'. $user,
            'password' => 'min:8|confirmed',
            
        ];

        $this->validate($request, $rules);

        if ($request->has('password')) {
            
            $user->password = Hash::make($request->password);
        }

        // checks if the user exists
        $user = User::findOrFail($user);

        // fill the user with the request info if that user exists
       $user->fill($request->all());

        // if the user is clean and therefore it has not change, we wont do any action in the DB
        if ($user->isClean()) {
           return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // if the user values request has changed then we will update save the record
        $user->save();

        return $this->successResponse($user);
    }


    /**
     * Removes an existing user 
     * @return Illuminate\Http\Response
     */
    public function destroy(Request $request, $user){
        
        $user = User::findOrFail($user);

        $user->delete();

        return $this->successResponse($user);
    }

    /**
     * Identifies the current user requesting the form data provided only if the user has an access_token linked to this user: grant_type password
     * @return Illuminate\Http\Response
     */
    public function me(Request $request){
    

        // return the user 
        return $this->validResponse($request->user());
    }

}
