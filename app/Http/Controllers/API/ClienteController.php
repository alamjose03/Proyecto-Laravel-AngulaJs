<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cliente;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'error' => false,
            'clientes'  => Cliente::all(),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation= Validator::make ($request->all(),[
            'nombre'=>'required',
            'email'=>'required|email|unique:clientes,email',
            'telefono'=>'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'error'=>true,
                'messages' =>$validation->errors(),
            ], 200);
        }
        else{
            $cliente = new Cliente;
            $cliente->nombre =$request->input('nombre');
            $cliente->email =$request->input('email');
            $cliente->telefono =$request->input('telefono');
            $cliente-> save();

            return response()->json([
                'error'=>false,
                'cliente' =>$cliente,
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = Cliente::find($id);

        if(is_null($cliente)){
            return response()->json([
                'error'=> true,
                'message' => "Cliente con id # $id no existe"   ,
            ], 404);
        }
        return response ()->json([
            'error'=> false,
            'cliente'=>$cliente,
        ],200);
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
        $validation= Validator::make($request->all(),[
            'nombre' => 'required',
            'email' => 'required|email',
            'telefono' => 'required',
        ]);

        if($validation->fails()){
            return response()->json([
                'error'=>true,
                'messages'=>$validation->errors(),
            ],200);
        }
        else{
            $cliente = Cliente::find($id);
            $cliente->nombre =$request->input('nombre');
            $cliente->email =$request->input('email');
            $cliente->telefono =$request->input('telefono');
            $cliente->save();

            return response()->json([
                'error'=>false,
                'cliente'=>$cliente,
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if(is_null($cliente)){
            return response()->json([
                'error'=>true,
                'message'=>"Cliente con id # $id no existe",
            ], 404);
        }
        $cliente->delete();

        return response()->json([
            'error'=> false,
            'message'=> "El registro se elimino correctamente # $id",
        ],200);
    }
}
