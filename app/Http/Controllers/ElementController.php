<?php

namespace App\Http\Controllers;

use App\Models\Element;
use App\Models\Attribut;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\Element\CreateElementRequest;

class ElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('elements.index');
    }

    public function fetch() {
        $elements = Element::all();
        $elements->load(['attributs','attributs.valuetype']);
        return $elements;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('elements.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(CreateElementRequest $request)
    {
        $formInput = $request->all();
        dd($formInput);
        //$formInput['typeelement'] = json_decode($formInput['typeelement'], true);
        $element = Element::create([
            'type_element_id' => $formInput['type_element_id']
        ]);
        foreach ($formInput as $key => $value) {
            $attribut = Attribut::where('uuid', $key)->first();
            if (! is_null($attribut)) {
                $attribut->setValue($element->id, $value);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Element  $element
     * @return Response
     */
    public function show(Element $element)
    {
        dd($element->object);
        return $element->object;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Element  $element
     * @return Response
     */
    public function edit(Element $element)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Element  $element
     * @return Response
     */
    public function update(Request $request, Element $element)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Element  $element
     * @return Response
     */
    public function destroy(Element $element)
    {
        //
    }
}
