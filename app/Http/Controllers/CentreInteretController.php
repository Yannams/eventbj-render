<?php

namespace App\Http\Controllers;

use App\Models\Centre_interet;
use App\Http\Requests\StoreCentre_interetRequest;
use App\Http\Requests\UpdateCentre_interetRequest;
use App\Models\User;

class CentreInteretController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $centre_interets = Centre_interet::all();
        return view('layout.SelectInterest',compact('centre_interets'));
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
    public function store(StoreCentre_interetRequest $request)
    {
        $user_id=auth()->user()->id;
        $user=User::find($user_id);
        $interests=$request->interest;
        foreach ($interests as $interest) {
            $user->centre_interets()->attach($interest,["created_at"=>now(), "updated_at"=>now()]);
        }
        return redirect()->route("evenement.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Centre_interet $centre_interet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Centre_interet $centre_interet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCentre_interetRequest $request, Centre_interet $centre_interet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Centre_interet $centre_interet)
    {
        //
    }
}
