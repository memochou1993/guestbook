<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SignatureResource;
use App\Http\Requests\SignatureRequest;
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
        return SignatureResource::collection($signature->paginate(request()->per_page));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SignatureRequest  $request
     * @param  \App\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function store(SignatureRequest $request, Signature $signature)
    {
        if ($request->validator) {
            return $request->validator->errors();
        }

        $signature = $signature->create($request->all());

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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SignatureRequest  $request
     * @param  \App\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function update(SignatureRequest $request, Signature $signature)
    {
        if ($request->validator) {
            return $request->validator->errors();
        }

        $signature->update($request->all());

        return new SignatureResource($signature);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Signature  $signature
     * @return \Illuminate\Http\Response
     */
    public function destroy(Signature $signature)
    {
        $signature->delete();
    }
}
