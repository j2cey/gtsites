<?php

namespace App\Http\Controllers;

use App\Models\SubtypeElement;
use App\Http\Requests\SubtypeElement\CreateSubtypeElementRequest;
use App\Http\Requests\SubtypeElement\UpdateSubtypeElementRequest;

class SubtypeElementController extends Controller
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
        $subtypeelements = SubtypeElement::orderBy('ord','ASC')->get();
        $subtypeelements->load(['typeelement','subtype']);
        return $subtypeelements;
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
    public function store(CreateSubtypeElementRequest $request)
    {
        $user = auth()->user();

        $formInput = $request->all();

        $ord = SubtypeElement::where('type_element_id', $formInput['type_element_id'])->count('id');

        $subtypeelement = SubtypeElement::create([
            'nom' => $formInput['nom'],
            'description' => $formInput['description'],
            'obligatoire' => $request->getCheckValue('obligatoire'),
            'type_element_id' => $formInput['type_element_id'],
            'subtype_element_id' => $formInput['subtype']['id'],
            'ord' => $ord,
        ]);

        return $subtypeelement->load(['typeelement','subtype']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubtypeElement  $subtypeElement
     * @return \Illuminate\Http\Response
     */
    public function show(SubtypeElement $subtypeElement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubtypeElement  $subtypeElement
     * @return \Illuminate\Http\Response
     */
    public function edit(SubtypeElement $subtypeElement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubtypeElement  $subtypeElement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubtypeElementRequest $request, SubtypeElement $subtypeelement)
    {
        $user = auth()->user();

        //$request->replace($request->all());
        $formInput = $request->all();

        if ($request->has('oldIndex') && $request->has('newIndex')) {
            $subtypeelement->reorder("type_element_id", $subtypeelement->type_element_id, $formInput['oldIndex'], $formInput['newIndex']);
            $subtypeelements = SubtypeElement::where('type_element_id',$formInput['type_element_id'])->orderBy('ord','ASC')->get();
            return $subtypeelements->load(['typeelement','subtype']);
        } else {

            $formInput['subtype'] = json_decode($formInput['subtype'], true);

            $subtypeelement->update([
                'nom' => $formInput['nom'],
                'description' => $formInput['description'],
                'obligatoire' => $request->getCheckValue('obligatoire'),
                'type_element_id' => $formInput['type_element_id'],
                'subtype_element_id' => $formInput['subtype']['id'],
            ]);

            return $subtypeelement->load(['typeelement','subtype']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubtypeElement  $subtypeElement
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubtypeElement $subtypeElement)
    {
        //
    }
}
