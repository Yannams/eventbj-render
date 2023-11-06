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
    
        $evenement_id=session('evenement_id');
        return view('admin.programmation.create', compact('evenement_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorechronogrammeRequest $request)
    {
        $evenement_id = $request->input('evenement_id');
        $evenement = Evenement::find($evenement_id);
    
        // Mise à jour de la date_heure_debut et date_heure_fin de l'événement
        
        $evenement->date_heure_debut = $request->input('date_heure_debut');
        $evenement->date_heure_fin = $request->input('date_heure_fin');
        $evenement->save();
    
        // Récupération de la date_activite depuis la première date de début
        $date_heure_debut = new \DateTime($request->date_heure_debut);
        $date_activite_get = $date_heure_debut->format('Y-m-d');
        $date_activite=new \DateTime($date_activite_get);// Utilisation de "\DateTime"
        $heure_debut = new \DateTime('00:00'); // Utilisation de "\DateTime"
        $heure_fin = new \DateTime('23:00'); // Utilisation de "\DateTime"
        // Récupération de date_fin à partir de la partie date de date_heure_fin
        $date_heure_fin = new \DateTime($request->date_heure_fin);
        $date_heure_fin_get= $date_heure_fin->format('Y-m-d');
        $date_fin = new \DateTime($date_heure_fin_get);
        $nom_activites = $request->input('nom_activite');
    
       //dd($date_activite);
        while ($date_activite <= $date_fin) {
            $heure = clone $heure_debut;
            $nom_activite_index = 0;
            while($heure <= $heure_fin) {
                // dd( $request);
              
                $chronogramme = new Chronogramme();
                $chronogramme->date_activite = $date_activite->format('Y-m-d');
                $chronogramme->heure_debut = $heure->format('H:i');
                $heure->modify('+1 hour');
                $chronogramme->heure_fin = $heure->format('H:i');
                $chronogramme->nom_activite = $nom_activites[$nom_activite_index]??null;
                $chronogramme->evenement_id = $evenement_id;
    
                if ( $nom_activites[$nom_activite_index] != null) {
                    $chronogramme->save();
                }
                $nom_activite_index++;
            }
            // Passage à la prochaine date
             $date_activite->modify('+1 day');
         }
    
        // Redirection ou autre traitement après l'enregistrement

         return redirect()->route('type ticket.create');

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chronogramme $chronogramme)
    {
        //
    }
}
