<?php

namespace App\Http\Controllers;

use App\Models\Attribut;
use Illuminate\Http\Request;
use App\Http\Requests\Attribut\CreateAttributRequest;
use App\Http\Requests\Attribut\UpdateAttributRequest;

class AttributController extends Controller
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
        $attributs = Attribut::orderBy('ord','ASC')->get();
        $attributs->load(['typeelement','valuetype']);
        return $attributs;
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
    public function store(CreateAttributRequest $request)
    {
        $user = auth()->user();

        $formInput = $request->all();

        $ord = Attribut::where('type_element_id', $formInput['type_element_id'])->count('id');

        $attribut = Attribut::create([
            'nom' => $formInput['nom'],
            'description' => $formInput['description'],
            'obligatoire' => $request->getCheckValue('obligatoire'),
            'est_libelle' => $request->getCheckValue('est_libelle'),
            'type_element_id' => $formInput['type_element_id'],
            'attribut_value_type_id' => $formInput['valuetype']['id'],
            'ord' => $ord,
        ]);

        return $attribut->load(['typeelement','valuetype']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attribut  $attribut
     * @return \Illuminate\Http\Response
     */
    public function show(Attribut $attribut)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attribut  $attribut
     * @return \Illuminate\Http\Response
     */
    public function edit(Attribut $attribut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attribut  $attribut
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAttributRequest $request, Attribut $attribut)
    {
        $user = auth()->user();

        //$request->replace($request->all());
        $formInput = $request->all();

        if ($request->has('oldIndex') && $request->has('newIndex')) {
            $attribut->reorder("type_element_id", $attribut->type_element_id, $formInput['oldIndex'], $formInput['newIndex']);
            $attributs = Attribut::where('type_element_id',$formInput['type_element_id'])->orderBy('ord','ASC')->get();
            return $attributs->load(['typeelement','valuetype']);
        } else {

            $formInput['valuetype'] = json_decode($formInput['valuetype'], true);

            $attribut->update([
                'nom' => $formInput['nom'],
                'description' => $formInput['description'],
                'obligatoire' => $request->getCheckValue('obligatoire'),
                'est_libelle' => $request->getCheckValue('est_libelle'),
                'type_element_id' => $formInput['type_element_id'],
                'attribut_value_type_id' => $formInput['valuetype']['id'],
            ]);

            return $attribut->load(['typeelement','valuetype']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attribut  $attribut
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attribut $attribut)
    {
        //
    }
}
