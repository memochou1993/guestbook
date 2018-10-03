<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Resources\SignatureResource;
use App\Http\Requests\StoreSignature;
use App\Signature;

class SignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function index(Signature $signature)
    {
        return SignatureResource::collection($signature->paginate(5));
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
    public function store(StoreSignature $request)
    {
        if ($request->validator) {
            return $request->validator->errors();
        }

        $signature = Signature::create($request->all());

        return new SignatureResource($signature);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function show(Signature $signature)
    {
        return new SignatureResource($signature);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Signature::destroy($id);
    }
}
