<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttributValueType;

class AttributValueTypeController extends Controller
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

    public function fetch() {
        $elements = AttributValueType::orderBy('nom','ASC')->get();
        //$elements->load(['element','valuetype']);
        return $elements;
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttributValueType  $attributValueType
     * @return \Illuminate\Http\Response
     */
    public function show(AttributValueType $attributValueType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttributValueType  $attributValueType
     * @return \Illuminate\Http\Response
     */
    public function edit(AttributValueType $attributValueType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttributValueType  $attributValueType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttributValueType $attributValueType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttributValueType  $attributValueType
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributValueType $attributValueType)
    {
        //
    }
}
