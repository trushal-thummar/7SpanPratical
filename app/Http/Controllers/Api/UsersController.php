<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

//Models
use App\Models\Hobbies;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Create user
     *
     * @param  [string] first_name
     * @param  [string] last_name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [object] photo
     * @param  [string] mobile
     * @param  [array] hobby_ids
     * @param  [integer] status
     * @return [string] message
     */
    public function store(Request $request)
    { 
        //Save User Information
        $reqResponse = app('App\Http\Controllers\Commons\UsersController')->store($request);

        //API Response
        return $reqResponse;
    }

    /**
     *Show user
     *
     * @param  [integer] user_id
     * @return [string] message
     * @return [array] user
     */
    public function show(Request $request)
    {
        //Delete User Information
        $reqResponse = app('App\Http\Controllers\Commons\UsersController')->show($request);

        //API Response
        return $reqResponse;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update user
     *
     * @param  [string] first_name
     * @param  [string] last_name
     * @param  [string] email
     * @param  [object] photo
     * @param  [string] mobile
     * @param  [array] hobby_ids
     * @param  [integer] status
     * @return [string] message
     */
    public function update(Request $request)
    {
        //Update User Information
        $reqResponse = app('App\Http\Controllers\Commons\UsersController')->update($request);

        //API Response
        return $reqResponse;
    }

    /**
     * Delete user
     *
     * @param  [integer] user_id
     * @return [string] message
     */
    public function destroy(Request $request)
    {
        //Delete User Information
        $reqResponse = app('App\Http\Controllers\Commons\UsersController')->destroy($request);

        //API Response
        return $reqResponse;
    }

    /**
     * Filter users
     *
     * @param  [integer] hobby_ids
     * @return [string] message
     * @return [array] hobbies
     */
    public function filterUsers(Request $request)
    {
        if(!\Auth::guard('api')->user()->roles->contains('name', 'Super Admin')){
            return response()->json(['message' => 'Error! Access denied.'], 401);
        }

        //Filter Users Information
        $reqResponse = app('App\Http\Controllers\Commons\UsersController')->filterUsers($request);

        //API Response
        return $reqResponse;
    }

    /**
     * Update user hobbies
     *
     * @param  [array] hobby_ids
     * @return [string] message
     */
    public function updateHobbies(Request $request)
    {
        //Update User Hobbies
        $reqResponse = app('App\Http\Controllers\Commons\UsersController')->updateHobbies($request);

        //API Response
        return $reqResponse;
    }
}
