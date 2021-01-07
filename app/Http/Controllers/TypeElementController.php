<?php

namespace App\Http\Controllers;

use App\Models\TypeElement;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\TypeElement\CreateTypeElementRequest;

class TypeElementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|Response
     */
    public function index()
    {
        return view('typeelements.index');
    }

    public function fetch() {
        $elements = TypeElement::all();
        $elements->load(['attributs','attributs.valuetype']);
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
    public function store(CreateTypeElementRequest $request)
    {
        $user = auth()->user();

        $formInput = $request->all();

        $typeelement = TypeElement::create([
            'nom' => $formInput['nom'],
            'description' => $formInput['description'],
            'user_id' => $user->id,
        ]);

        return $typeelement->load(['attributs','attributs.valuetype']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TypeElement  $typeElement
     * @return \Illuminate\Http\Response
     */
    public function show(TypeElement $typeElement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TypeElement  $typeElement
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeElement $typeElement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TypeElement  $typeElement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeElement $typeelement)
    {
        $formInput = $request->all();
        foreach ($formInput as $key => $value) {
            if ($value === "null") {
                $request->replace([$key => null]);
            }
        }

        // TODO: Validadtion

        $typeelement->update([
            'nom' => $formInput['nom'],
            'description' => $formInput['description'],
        ]);

        return $typeelement->load(['attributs','attributs.valuetype']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TypeElement  $typeElement
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeElement $typeElement)
    {
        //
    }
}
