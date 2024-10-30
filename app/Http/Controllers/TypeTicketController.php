<?php

namespace App\Http\Controllers;

use App\Models\type_ticket;
use App\Http\Requests\Storetype_ticketRequest;
use App\Http\Requests\Updatetype_ticketRequest;
use App\Models\evenement;

class TypeTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(session('evenement_id') && session('TypeLieu') && session('evenement_nom') && session('type_ticket') && session('localisation')){
            $evenement_id=session('evenement_id');
            $evenement = evenement::find($evenement_id);
            $promoteur=auth()->user()->profil_promoteur->id;
            if($evenement->profil_promoteur_id==$promoteur){
                $typeTickets=$evenement->type_tickets;
                return view("admin.type_ticket.index", compact("typeTickets"));
            } else {
                return redirect()->route('UnauthorizedUser');
            }
        }else {
            return redirect()->route('Create_event');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(session('evenement_id') && session('TypeLieu') && session('evenement_nom')&& session('localisation')){
            $evenement_id=session('evenement_id');
            $evenement = evenement::find($evenement_id);
            $promoteur=auth()->user()->profil_promoteur->id;
            if($evenement->profil_promoteur_id==$promoteur){
                return view('admin.type_ticket.create', compact('evenement_id','evenement'));
            }else{
                return redirect()->route('UnauthorizedUser');
            }
        }else{
            return redirect()->route('Create_event');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Storetype_ticketRequest $request)
    {
        $type_ticket= new type_ticket;
        $img = $request->file('image_ticket');
        $destinationPath = public_path('image_ticket'); // Le chemin de destination où vous souhaitez déplacer le fichier

        // Assurez-vous que le répertoire de destination existe
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $fileName = time() . '_' . $img->getClientOriginalName(); // Générez un nom de fichier unique si nécessaire

        $img->move($destinationPath, $fileName); // Déplacez le fichier vers le répertoire de destination

        // Maintenant, $destinationPath.'/'.$fileName contient le chemin complet du fichier déplacé
        $imagePath='image_ticket/'.$fileName;
        $type_ticket->image_ticket=$imagePath;
        $type_ticket->nom_ticket=$request->nom_ticket;
        if($request->format=="Ticket"){
            $type_ticket->prix_ticket=$request->prix_ticket;
        }elseif($request->format=="Invitation"){
            $type_ticket->texte=$request->texte;
        }
        // $type_ticket->frais_ticket=$request->frais_ticket;
        $type_ticket->format=$request->format;
        $type_ticket->place_dispo=$request->place_dispo;
        $type_ticket->quantite=$request->place_dispo;
        $type_ticket->evenement_id=$request->evenement_id;
        $type_ticket->methodeProgrammationLancement=$request->methodeProgrammationLancement;
        $type_ticket->Date_heure_lancement=$request->Date_heure_lancement;
        $type_ticket->methodeProgrammationFermeture=$request->methodeProgrammationFermeture;
        $type_ticket->Date_heure_fermeture=$request->Date_heure_fermeture;
        $type_ticket->save();
        $evenement=evenement::find($request->evenement_id);
        $evenement->Etape_creation=5;
        $evenement->save();
        session(['type_ticket'=>$type_ticket->id]);
        return redirect()->route("type_ticket.index")->with('message','Ticket créé');
    }

    /**
     * Display the specified resource.
     */
    public function show(type_ticket $type_ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(type_ticket $type_ticket)
    {
        $type_ticket=type_ticket::find($type_ticket->id);
        return view('admin.type_ticket.edit',compact('type_ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatetype_ticketRequest $request, type_ticket $type_ticket)
    {
        
       $data=$request->validate(
            [
                "image_ticket"=>"extensions:jpg,png,svg",
                "nom_ticket"=>"required",
                "prix_ticket"=>"required|numeric",
                "frais_ticket"=>"required|numeric",
                "place_dispo"=>"required|numeric",
                "methodeProgrammationLancement"=>"required",
                "Date_heure_lancement"=>"Date",
                "methodeProgrammationFermeture"=>"required",
                "Date_heure_fermeture"=>"Date",

            ]
            );
        $type_ticket->update($data);
        return redirect()->route('billetterie');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(type_ticket $type_ticket)
    {
        //
    }

    public function terminus(){
        session()->forget(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket']);

        
        return redirect()->route('MesEvenements');
    }

    public function billetterie(){

        $evenements=evenement::all();
        return view('admin.type_ticket.billetterie',compact('evenements'));
    }
}
