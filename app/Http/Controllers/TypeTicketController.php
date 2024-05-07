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
        $evenement_id=session('evenement_id');
        $evenement= Evenement::with('type_tickets')->find($evenement_id);
        if ($evenement) {
            $typeTickets = $evenement->type_tickets;
            return view("admin.type_ticket.index", compact("typeTickets"));
        } else {
            // Gérez le cas où l'événement n'a pas été trouvé
           // return view("admin.type_ticket.index", compact("evenement"));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $evenement_id=session('evenement_id');
        $evenement=evenement::find($evenement_id);
        return view('admin.type_ticket.create', compact('evenement_id','evenement'));
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
        $type_ticket->prix_ticket=$request->prix_ticket;
        $type_ticket->frais_ticket=$request->frais_ticket;
        $type_ticket->type_ticket=$request->type_ticket;
        $type_ticket->place_dispo=$request->place_dispo;
        $type_ticket->evenement_id=$request->evenement_id;
        $type_ticket->methodeProgrammationLancement=$request->methodeProgrammationLancement;
        $type_ticket->Date_heure_lancement=$request->Date_heure_lancement;
        $type_ticket->methodeProgrammationFermeture=$request->methodeProgrammationFermeture;
        $type_ticket->Date_heure_fermeture=$request->Date_heure_fermeture;
        $type_ticket->save();

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
                "image_ticket"=>"required",
                "nom_ticket"=>"required",
                "prix_ticket"=>"required|numeric",
                "frais_ticket"=>"required|numeric",
                "place_dispo"=>"required|numeric",
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
