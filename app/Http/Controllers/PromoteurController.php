<?php

namespace App\Http\Controllers;

use App\Models\Promoteur;
use App\Http\Requests\StorePromoteurRequest;
use App\Http\Requests\UpdatePromoteurRequest;
use Illuminate\Support\Facades\Auth;

class PromoteurController extends Controller
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
    public function store(StorePromoteurRequest $request)
    {
        $validatedData=$request->validate(
            [
                'nom'=>'required',
                'type_organisateur'=>'required'
            ]
            );
        
            $promoteur=new Promoteur;
            $promoteur->nom=$request->nom;
            $promoteur->type_organisateur=$request->type_organisateur;
            $promoteur->user_id=Auth::user()->id;
            $promoteur->save();
            Auth::user()->assignRole('promoteur');
            $route=session('route');
            session()->forget('route');
          
            return redirect()->route($route);
       
    }

    /**
     * Display the specified resource.
     */
    public function show(Promoteur $Promoteur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Promoteur $Promoteur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromoteurRequest $request, Promoteur $Promoteur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promoteur $Promoteur)
    {
        //
    }
}
