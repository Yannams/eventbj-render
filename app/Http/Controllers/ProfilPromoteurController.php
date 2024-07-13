<?php

namespace App\Http\Controllers;


use App\Http\Requests\StoreProfil_PromoteurRequest;
use App\Http\Requests\UpdateProfil_PromoteurRequest;
use App\Models\Profil_promoteur;
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
        return view('auth.Promoteur');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfil_PromoteurRequest $request)
    {
        $validatedData=$request->validate(
            [
                'nom'=>'required',
                'type_organisateur'=>'required'
            ]
            );
        
            $promoteur=new Profil_promoteur;
            $promoteur->nom=$request->nom;
            $promoteur->type_organisateur=$request->type_organisateur;
            $promoteur->user_id=Auth::user()->id;
            $promoteur->save();
            Auth::user()->removeRole('User');
            Auth::user()->assignRole('promoteur');
            $route=session('route');
            session()->forget('route');
          
            return redirect()->route($route);
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Profil_promoteur $Promoteur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profil_promoteur $Promoteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProfil_PromoteurRequest $request, Profil_Promoteur $Promoteur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profil_promoteur $Promoteur)
    {
        //
    }
}
