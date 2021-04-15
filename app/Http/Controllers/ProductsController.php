<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Produt;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Produt::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = array(
            'name'=>'required',
            'slug'=>'required', 
            'price'=>'required',
        );
        $validator = Validator::make($request->all(), $validatedData);
        if ($validator->fails()) {
            return response()->json([
                'Message'=>'Parametre manquant',
                'Error'=>$validator->errors()
            ], 401);
        } else {
            return $result= Produt::create($request->all());
            if ($result) {
                return response()->json(Produt::all(), 200);
            } else {
                response()->json(['Message' => "Error d'enregistrement"], 401);
            }
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
        return Produt::find($id);
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
        $products=Produt::find($id);
        $products->update($request->all());
        return $products;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Produt::destroy($id);
    }

    /**
     * Search for name.
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Produt::where(
            'name',
            'like',
            '%'.$name.'%'
        )->get();
    }
}
