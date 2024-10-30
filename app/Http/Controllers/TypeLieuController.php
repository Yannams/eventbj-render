<?php

namespace App\Http\Controllers;

use App\Models\type_lieu;
use App\Http\Requests\Storetype_lieuRequest;
use App\Http\Requests\Updatetype_lieuRequest;
use App\Models\evenement;

class TypeLieuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $type_lieu= type_lieu::all();
        return view('admin.type_lieu.index', compact('type_lieu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.type_lieu.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storetype_lieuRequest $request)
    {
        $type_lieu = new type_lieu;
        $type_lieu->nom_type = $request->nom_type;
        $type_lieu->description = $request->description;
        $type_lieu->save();
        return redirect()->route('type_lieu.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(type_lieu $type_lieu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(type_lieu $type_lieu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatetype_lieuRequest $request, type_lieu $type_lieu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(type_lieu $type_lieu)
    {
        //
    }
    //je dois afficher une liste des type de lieu, sélectionner le type de lieu 

    public function select_type_lieu()
    {   
        if(session('evenement_id')){
            $evenement_id=session('evenement_id');
            $evenement = evenement::find($evenement_id);
            $promoteur=auth()->user()->profil_promoteur->id;
            if($evenement->profil_promoteur_id==$promoteur){
                $type_lieu= type_lieu::all();
                return view('admin.type_lieu.select_type_lieu', compact('type_lieu','evenement_id','evenement'));
            }else {
                return  redirect()->route('UnauthorizedUser');
            }

        }else {
            return redirect()->route('Create_event');
        }
        
    }


    /*renvoyer vers le formulaire de création des évènements que je vais enregistrer 
    pour envoyer vers la programmation de l'évènement */ 

    public function type_lieu_selected(Storetype_lieuRequest $request)
    {
        $validatedData= $request->validate([
            'type_lieu_event'=>'required'
        ]);  
       
        $evenement=evenement::find(session('evenement_id'));
        $evenement->type_lieu_id=$request->type_lieu_event;
        $evenement->Etape_creation=2;
        $evenement->save();
        session(['TypeLieu'=>$request->type_lieu_event]); 
        return redirect()->route('evenement.edit',$evenement);
    }
}

