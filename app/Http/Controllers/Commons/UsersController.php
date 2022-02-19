<?php

namespace App\Http\Controllers\Commons;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

//Models
use App\User;

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Request
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'photo' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'mobile' => 'required|min:10',
            'hobby_ids' => 'required',
            'status' => 'required',
        ]);

        try{
            //Create Object Of The User Model
            $user = new User;
            $user->name = $request->first_name.' '.$request->last_name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->mobile = $request->mobile;
            $user->is_status = $request->status;

            //Check File Object Exist Or Not
            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $path = 'storage/users';
                $imageName = fileUpload($path, $file);

                $user->photo = $imageName;
            }

            //Save User Information
            $user->save();

            //Sync Hobbies Information
            $user->hobbies()->sync($request->hobby_ids);

            return response()->json(['message' => 'Success! User has been created.', 'user' => $user], 200);
        }
        catch(\Exception $e){
            \Log::error('Error in create user '.$e->getMessage());

            return response()->json(['message' => 'Error! Please try again.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // Validate Request
        $request->validate(['user_id' => 'required']);

        try{
            //Verify user exist or not in our records
            $user = User::find($request->user_id);
            
            //Check User Record Exist Or Not
            if($user){ 
                return response()->json(['message' => 'Success! User has been found.', 'user' => $user], 200);
            }else{
                return response()->json(['message' => 'Error! User not found on our records.'], 404);
            }
        }
        catch(\Exception $e){
            \Log::error('Error in get user detail'.$e->getMessage());

            return response()->json(['message' => 'Error! Please try again.'], 500);
        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Validation Params
        $validateArr = [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|email',
            'photo' => 'required|mimes:jpeg,jpg,png,gif|max:10000',
            'mobile' => 'required|min:10',
            'hobby_ids' => 'required',
            'status' => 'required',
        ];

        //Get Detail Of The User
        $user = \Auth::guard('api')->user();

        if(!empty($user) && $user->email != $request->email){
            $validateArr['email'] = 'required|string|email|unique:users';
        }

        if($request->hasFile('photo')){
            $validateArr['photo'] = 'required|mimes:jpeg,jpg,png,gif|max:10000';
        }

        // Validate Request
        $request->validate($validateArr);

        try{
            $user->name = $request->first_name.' '.$request->last_name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->is_status = $request->status;

            //Check File Object Exist Or Not
            if($request->hasFile('photo')){
                $file = $request->file('photo');
                $path = 'storage/users';
                $imageName = fileUpload($path, $file);

                $user->photo = $imageName;
            }

            //Update User Information
            $user->save();

            //Sync Hobbies Information
            $user->hobbies()->sync($request->hobby_ids);

            return response()->json(['message' => 'Success! User has been updated.', 'user' => $user], 200);
        }
        catch(\Exception $e){
            \Log::error('Error in update user '.$e->getMessage());

            return response()->json(['message' => 'Error! Please try again.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Validate Request
        $request->validate(['user_id' => 'required']);

        try{
            //Verify user exist or not in our records
            $user = User::find($request->user_id);
            
            //Check User Record Exist Or Not
            if($user){ 
                //Delete Hobbies Records Exist With This User
                $user->hobbies()->detach();
                
                //Delete User
                $user->delete();
                return response()->json(['message' => 'Success! User has been deleted.'], 200);
            }else{
                return response()->json(['message' => 'Error! User not found on our records.'], 404);
            }
        }
        catch(\Exception $e){
            \Log::error('Error in delete user '.$e->getMessage());

            return response()->json(['message' => 'Error! Please try again.'], 500);
        }  
    }

    public function filterUsers(Request $request)
    {   
        // Validate Request
        $request->validate(['hobby_ids' => 'required']);

        //Get Hobbies Based On Ids
        $hobbies = Hobbies::whereIn('id', $request->hobby_ids)->with('users')->get();

        return response()->json([
                'message' => 'Success! Users detail list found.',
                'hobbies' => $hobbies
            ], 200);
    }

    public function updateHobbies(Request $request)
    {
        // Validate Request
        $request->validate(['hobby_ids' => 'required']);

        //Get Detail Of The User
        $user = \Auth::guard('api')->user();

        try{
            //Sync Hobbies Information
            $user->hobbies()->sync($request->hobby_ids);

            return response()->json(['message' => 'Success! User hobbies has been updated.'], 200);
        }
        catch(\Exception $e){
            \Log::error('Error in update hobbies user '.$e->getMessage());

            return response()->json(['message' => 'Error! Please try again.'], 500);
        }
    }
}
