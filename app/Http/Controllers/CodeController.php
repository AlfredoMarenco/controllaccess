<?php

namespace App\Http\Controllers;

use App\Models\Admin\Code;
use App\Http\Requests\StoreCodeRequest;
use App\Http\Requests\UpdateCodeRequest;

class CodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $codes = Code::all();
        return $codes;
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
     * @param  \App\Http\Requests\StoreCodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCodeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        $response = Code::where('barcode',$code)->first();
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function edit(Code $code)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCodeRequest  $request
     * @param  \App\Models\Admin\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCodeRequest $request, $code)
    {
        $updateCode = Code::where('barcode',$code)->first();
        $updateCode->update([
            'status' => "0"
        ]);

        return $updateCode;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Code $code)
    {
        //
    }
}
