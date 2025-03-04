<?php

namespace App\Http\Controllers;

use App\Models\evenement;
use App\Models\tickets_verifications;
use App\Http\Requests\Storetickets_verificationsRequest;
use App\Http\Requests\Updatetickets_verificationsRequest;
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
        if(isset($_GET['controleur'])){
            if($_GET['controleur']=='promoteur'){
                // dd($evenement->profil_promoteur_id);
                $verifications=tickets_verifications::where('evenement_id',$evenement->id)
                                ->where('profil_promoteur_id', $evenement->profil_promoteur_id)
                                ->get();  
                return view('admin.TicketVerification.verificationHistoric',compact('verifications','controleurs','evenement'));

            }
            $verifications=tickets_verifications::where('evenement_id',$evenement->id)
                            ->where('controleur_id',$_GET['controleur'])
                            ->get();
            return view('admin.TicketVerification.verificationHistoric',compact('verifications','controleurs','evenement'));
        }
        $verifications=tickets_verifications::where('evenement_id',$evenement->id)->get();
        return view('admin.TicketVerification.verificationHistoric',compact('verifications','controleurs','evenement'));
    }
}
