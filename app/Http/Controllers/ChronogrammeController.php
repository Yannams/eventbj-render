<?php

namespace App\Http\Controllers;

use App\Models\chronogramme;
use App\Http\Requests\StorechronogrammeRequest;
use App\Http\Requests\UpdatechronogrammeRequest;
use App\Models\evenement;
class ChronogrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.programmation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $chronogrammes=chronogramme::where('evenement_id',$_GET['event'])->get();
        $evenement=evenement::find($_GET['event']);
        return view('admin.programmation.create',compact('evenement','chronogrammes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorechronogrammeRequest $request)
    {
       $chronogramme=new chronogramme();
       $chronogramme->evenement_id=$request->evenement_id;  
       $chronogramme->heure_debut=$request->heure_debut;
       $chronogramme->heure_fin=$request->heure_fin;
       $chronogramme->nom_activite=$request->nom_activite;
       $chronogramme->date_activite=$request->date_activite;
       $chronogramme->save();
       return response()->json([
        'success'=>true,
        'chronogramme_id'=>$chronogramme->id,
        'evenement_id'=>$chronogramme->evenement_id,
        'heure_debut'=>$chronogramme->heure_debut,
        'heure_fin'=>$chronogramme->heure_fin,
        'nom_activite'=>$chronogramme->nom_activite,
        'date_activite'=>$chronogramme->date_activite,
       ]);
    }
    
    


    /**
     * Display the specified resource.
     */
    public function show(chronogramme $chronogramme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(chronogramme $chronogramme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatechronogrammeRequest $request, chronogramme $chronogramme)
    {
       $chronogramme = chronogramme::find($chronogramme->id);
       $chronogramme->heure_debut=$request->heure_debut;
       $chronogramme->heure_fin=$request->heure_fin;
       $chronogramme->nom_activite=$request->nom_activite;
       $chronogramme->save();
       return response()->json([
        'success'=>true,
        'chronogramme_id'=>$chronogramme->id,
        'evenement_id'=>$chronogramme->evenement_id,
        'heure_debut'=>date('H:i',strtotime($chronogramme->heure_debut)),
        'heure_fin'=>date('H:i',strtotime($chronogramme->heure_fin)),
        'nom_activite'=>$chronogramme->nom_activite,
        'date_activite'=>$chronogramme->date_activite,
       ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chronogramme $chronogramme)
    {
        //
    }

    public function edit_chronogramme(evenement $evenement ){
        $evenement_id=$evenement->id;
        $chronogramme=chronogramme::where('evenement_id',$evenement_id)->get();
        
        return view('admin.programmation.edit_programmation',compact('evenement','evenement_id','chronogramme'));
    }


}
