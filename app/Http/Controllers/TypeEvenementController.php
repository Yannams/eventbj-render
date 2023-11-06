<?php

namespace App\Http\Controllers;

use App\Models\type_evenement;
use App\Http\Requests\Storetype_evenementRequest;
use App\Http\Requests\Updatetype_evenementRequest;

class TypeEvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storetype_evenementRequest $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(type_evenement $type_evenement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(type_evenement $type_evenement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatetype_evenementRequest $request, type_evenement $type_evenement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(type_evenement $type_evenement)
    {
        //
    }
}
