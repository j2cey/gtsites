<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttributValueType;
use Illuminate\Support\Facades\DB;

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
        $attributvaluetypes = AttributValueType::orderBy('nom','ASC')->get();
        //$elements->load(['element','valuetype']);
        return $attributvaluetypes;
    }

    public function fetchcomposedsingle($id) {
        $valuetype = AttributValueType::find($id);
        if (is_null($valuetype->model_filterfield)) {
            $valueslist_raw = $valuetype->model_classname::get()->pluck("label", "id")->toArray();
        } else {
            $valueslist_raw = $valuetype->model_classname::where($valuetype->model_filterfield,$valuetype->model_filterfieldvalue)
                ->get();
        }

        //dd($valuetype, "fetchcomposed", $id);

        return $valueslist_raw->map(function ($value, $key) {
            return [
                'id' => $value->id,
                'label' => $value->label
            ];
        });
    }

    public function fetchcomposedall() {
        $valueslist = [];
        $valuetypescomposed = AttributValueType::where('est_compose', 1)->get();
        foreach ($valuetypescomposed as $valuetype) {
            $valueslist[$valuetype->id] = $this->fetchcomposedsingle($valuetype->id);
        }

        return $valueslist;
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
