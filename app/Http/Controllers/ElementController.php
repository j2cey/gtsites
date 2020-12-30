<?php

namespace App\Http\Controllers;

use App\Models\Element;
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
        $elements->load(['elementparent','attributs','attributs.valuetype','elementenfants','elementenfants.attributs']);
        return $elements;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(CreateElementRequest $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Element  $element
     * @return Response
     */
    public function show(Element $element)
    {
        //
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
