<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $data = Buku::orderBy("id", "asc")->get();

        return response()->json(
            [
                'status' => true,
                'message' => 'Data found',
                'data' => $data,
            ], 200
        );
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
        $payload = new Buku;

        $rules = [
            'judul' =>'required',
            'pengarang' =>'required',
            'tanggal_publikasi' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Failed create data",
                'data' => $validator->errors(),
            ], 500
            );
        }

        $payload->judul =  $request->judul;
        $payload->pengarang =  $request->pengarang;
        $payload->tanggal_publikasi =  $request->tanggal_publikasi;

        $save =  $payload->save();

        return response()->json(
            [
                'status' => true,
                'message' => "success create data",
                'data' => $save,
            ]
        );
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

        $data = Buku::find($id);
        if($data){
            return response()->json(

                [
                    "status" => true,
                    "massege" => "Data found",
                    "data" => $data,
    
                ], 200
            );
        } else {
            return response()->json(

                [
                    "status" => false,
                    "massege" => "Data not found",
                ], 404
            );
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        $payload = Buku::find($id);

        if(empty($payload)){
            return response()->json([
                'status' => false,
                'massge' => "Data not found",
            ],404);
        }

        $rules = [
            'judul' =>'required',
            'pengarang' =>'required',
            'tanggal_publikasi' => 'required|date',
        ];

        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Failed create data",
                'data' => $validator->errors(),
            ], 500
            );
        }

        $payload->judul =  $request->judul;
        $payload->pengarang =  $request->pengarang;
        $payload->tanggal_publikasi =  $request->tanggal_publikasi;

        $save =  $payload->save();

        return response()->json(
            [
                'status' => true,
                'message' => "success update data",
                'data' => $save,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        $payload = Buku::find($id);

        if(empty($payload)){
            return response()->json([
                'status' => false,
                'massge' => "Data not found",
            ], 404);
        }

        $post =  $payload->delete();

        return response()->json(
            [
                'status' => true,
                'message' => "success delete data",
                'data' => $post,
            ]
        );
    }
}
