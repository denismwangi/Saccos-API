<?php

namespace App\Http\Controllers;
use App\Http\Resources\Saccos as SaccosResource;

use Illuminate\Http\Request;
use App\Models\Saccos;
use Validator;

class SaccosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sacco = Saccos::paginate(2);
        return response()->json(["saccos"=>$sacco]);

       // return new SaccosResource($sacco); 
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
        //
       $validator = Validator::make($request->all(),[
        'name' => ['required', 'string', 'max:255','unique:saccos'],
            'description' => ['required', 'string',],
           'time_of_contribution' => 'required',
          'min_to_contribute' =>'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' =>$validator->errors()], 401);
        # code...
        
    }

    $input = $request->all();
    $sacco = Saccos::create($input);

    return response()->json(['success'=>" sacco created successfully"], 200);

                // return $request;

      // Saccos::create($request->all());
        //Saccos::create($validator);
        //return response()->json(["message" => "sacco created successfully"]);


        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Saccos $sacco)
    {
        //
       // return $sacco;
        return new SaccosResource($sacco);
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
    public function update(Request $request, Saccos $sacco)
    {
        //
      $updatedData = $sacco->update($request->all());

      return response()->json(["message" => "updated successfully!!"], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Saccos $sacco)
    {
        //
        $sacco->delete();

        return response()->json(["message" => "deleted successfully!!"], 200);
    }


    /**
     * restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore(Saccos $sacco , $id)
    {
        //
       // $sacco->restore();

       $data = Saccos::withTrashed()->find($id);
       $data->restore();

        return response()->json(["message" => "sacco restored successfully!!"], 200);
    }
}
