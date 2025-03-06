<?php

namespace App\Http\Controllers;

use App\Models\evenement;
use App\Models\tickets_verifications;
use App\Http\Requests\Storetickets_verificationsRequest;
use App\Http\Requests\Updatetickets_verificationsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsVerificationsController extends Controller
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
    public function store(Storetickets_verificationsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(tickets_verifications $tickets_verifications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(tickets_verifications $tickets_verifications)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatetickets_verificationsRequest $request, tickets_verifications $tickets_verifications)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tickets_verifications $tickets_verifications)
    {
        //
    }

    public function AllEvents(){
        $promoteur_id=Auth::user()->Profil_promoteur->id;
        $evenements=evenement::where('profil_promoteur_id',$promoteur_id)->get();
        return view('admin.TicketVerification.EventToControl',compact('evenements'));
    }

    public function VerificationHistoric(evenement $evenement){
        $controleurs=$evenement->profil_promoteur->controleurs;
        $verifications=tickets_verifications::where('evenement_id',$evenement->id)->get();
        return view('admin.TicketVerification.verificationHistoric',compact('verifications','controleurs','evenement'));
    }

    public function historicFilter(Request $request){
        if($request->role=="controleur"){
            $verifications=tickets_verifications::where('evenement_id',$request->evenement_id)->where('controleur_id',$request->id)->get()->map(function ($historic) {
                $participant=$historic->ticket_id ? $historic->ticket->user->name : "";
                $compte_controleur=$historic->controleur_id ? $historic->controleur->ControleurId : ($historic->profil_promoteur_id ? $historic->profil_promoteur->pseudo : "");
                $role=$historic->controleur_id ? "Controleur" : ($historic->profil_promoteur_id ? "Promoteur" : "");
                return [
                    'participant' => $participant,
                    'nom_controleur' => $historic->nom_controleur,
                    'num_controleur' => $historic->num_controleur,
                    'mail_controleur' => $historic->mail_controleur,
                    'compte_controleur' => $compte_controleur,
                    'role'=>$role,
                    'statut' => $historic->statut,
                    'created_at' => $historic->created_at->format('d/m/Y H:i'), // Format personnalisé    
                ];
            });
        }
        if($request->role=="promoteur"){
            $verifications=tickets_verifications::where('evenement_id',$request->evenement_id)->where('profil_promoteur_id',$request->id)->get()->map(function ($historic) {
                $participant=$historic->ticket_id ? $historic->ticket->user->name : "";
                $compte_controleur=$historic->controleur_id ? $historic->controleur->ControleurId : ($historic->profil_promoteur_id ? $historic->profil_promoteur->pseudo : "");
                $role=$historic->controleur_id ? "Controleur" : ($historic->profil_promoteur_id ? "Promoteur" : "");
                return [
                    'participant' => $participant,
                    'nom_controleur' => $historic->nom_controleur,
                    'num_controleur' => $historic->num_controleur,
                    'mail_controleur' => $historic->mail_controleur,
                    'compte_controleur' => $compte_controleur,
                    'role'=>$role,
                    'statut' => $historic->statut,
                    'created_at' => $historic->created_at->format('d/m/Y H:i'), // Format personnalisé    
                ];
            });
        }
        if($request->role=="tout"){
            $verifications=tickets_verifications::where('evenement_id',$request->evenement_id)->get()->map(function ($historic) {
                $participant=$historic->ticket_id ? $historic->ticket->user->name : "";
                $compte_controleur=$historic->controleur_id ? $historic->controleur->ControleurId : ($historic->profil_promoteur_id ? $historic->profil_promoteur->pseudo : "");
                $role=$historic->controleur_id ? "Controleur" : ($historic->profil_promoteur_id ? "Promoteur" : "");
                return [
                    'participant' => $participant,
                    'nom_controleur' => $historic->nom_controleur,
                    'num_controleur' => $historic->num_controleur,
                    'mail_controleur' => $historic->mail_controleur,
                    'compte_controleur' => $compte_controleur,
                    'role'=>$role,
                    'statut' => $historic->statut,
                    'created_at' => $historic->created_at->format('d/m/Y H:i'), // Format personnalisé    
                ];
            });
        }

        return response()->json($verifications);
    }
}
