<?php

namespace App\Http\Controllers;

use App\Models\Controleur;
use App\Http\Requests\StoreControleurRequest;
use App\Http\Requests\UpdateControleurRequest;
use App\Models\Profil_promoteur;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ControleurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=Auth::user();
        $profil_promoteur_id=$user->Profil_promoteur->id;
        $controleurs=Controleur::where('profil_promoteur_id',$profil_promoteur_id)->get();

        return view('admin.controleur.index',compact('controleurs'));
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
    public function store(StoreControleurRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Controleur $controleur)
    {
        return view('admin.controleur.show',compact('controleur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Controleur $controleur)
    {   
        $evenements=$controleur->profil_promoteur->evenements->where('date_heure_fin','>=',now());
        return view('admin.controleur.edit',compact('controleur','evenements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateControleurRequest $request, Controleur $controleur)
    {
        $validatedData=$request->validate([
            'name'=>'required',
            'evenement_id'=>'required',
            'password'=>'required|confirmed',
        ]);
        $controleur->evenements()->attach($request->evenement_id,['name'=>$request->name,'telephone'=>$request->telephone,'email'=>$request->email,'statut_affectation'=>'affecté','created_at'=>now(),'updated_at'=>now()]);
        $user_id=$controleur->user_id;
        $user=User::find($user_id);
        $user->password=Hash::make($request->password);
        $user->update();
        return redirect()->route('controleur.index')->with('message'," Le controleur $controleur->ControleurId est activé");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Controleur $controleur)
    {
        
    }

    public function choiceProcess(){
        return view('admin.controleur.choiceProcess');
    }

    public function controleurAccess(){
        $user_id=Auth::user()->id;
        $controleur=User::find($user_id)->Controleur;
        
        return view('admin.controleur.scanTicket');
    }

    public function validTicket(){
        return view('admin.controleur.validTicket');
    }
    public function verifiedTicket(){
        return view('admin.controleur.verifiedTicket');
    }
    public function invalidTicket(){
        return view('admin.controleur.invalidTicket');
    }
}
