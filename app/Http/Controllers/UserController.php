<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller; 
use App\Models\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Illuminate\support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{

    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::paginate(2);
        return response()->json(["users" =>$user]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //

         $updatedData = $user->update($request->all());

      return response()->json(["message" => "updated successfully!!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, User $user)
    {
        //
         $user->delete();

        return response()->json(["message" => "deleted successfully!!"], 200);
    }
    public function restore($id, User $user){

       $data = User::withTrashed()->find($id);
       $data->restore();

        return response()->json(["message" => "user restored successfully!!"], 200);

    }


    public function login(Request $request ,User $user){

        $request->validate([
        'email' => 'required',
        'password' => 'required'
    ]);
        

        if (Auth::attempt(['email' => request('email'), 
            'password'=> request('password')])) {
            $user = Auth::user();
           $success['token'] = $user->createToken('my accessToken')->accessToken;
          //  return response()->json(['success' => "successfully login"], $this->successStatus);

        return response()->json(['user data' =>[
                 'message' => "successfully login",
                'user' => Auth::user(),
                'access_token' => $success,
                'token_type' => 'Bearer',
                //'expires_at' =>Carbon::parse($success->expires_at)->toDateTimeString()
            ]]);

            # code...
        }else{
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
public function register(Request $request ,User $user){
   
   $validator = Validator::make($request->all(),[
        'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'string', 'min:8'],
          'c_password' =>'required|same:password',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' =>$validator->errors()], 401);
        # code...
        
    }
    $input = $request->all();
    $input['password'] = Hash::make($input['password']);
    $user = User::create($input);
    $success['token'] = $user->createToken('my accessToken')->accessToken;
    $success['name'] = $user->name;

    return response()->json(['message' => "register success",'success'=>$success], $this->successStatus);

      
}
/** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    }

}
