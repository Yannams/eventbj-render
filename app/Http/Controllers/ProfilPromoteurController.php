<?php

namespace App\Http\Controllers;

use App\Models\ProfilPromoteur;
use App\Http\Requests\StoreProfilPromoteurRequest;
use App\Http\Requests\UpdateProfilPromoteurRequest;
use Illuminate\Support\Facades\Auth;

class ProfilPromoteurController extends Controller
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
        return view('auth.profilPromoteur');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfilPromoteurRequest $request)
    {
        $validatedData=$request->validate(
            [
                'nom'=>'required',
                'type_organisateur'=>'required'
            ]
            );
        
            $promoteur=new ProfilPromoteur;
            $promoteur->nom=$request->nom;
            $promoteur->type_organisateur=$request->type_organisateur;
            $promoteur->user_id=Auth::user()->id;
            $promoteur->save();
            Auth::user()->assignRole('promoteur');
            return redirect()->route('Create_event');
       
    }

    /**
     * Display the specified resource.
     */
    public function show(ProfilPromoteur $profilPromoteur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProfilPromoteur $profilPromoteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfilPromoteurRequest $request, ProfilPromoteur $profilPromoteur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProfilPromoteur $profilPromoteur)
    {
        //
    }
}
