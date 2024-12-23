<?php

namespace App\Http\Controllers;

use App\Models\type_ticket;
use App\Http\Requests\Storetype_ticketRequest;
use App\Http\Requests\Updatetype_ticketRequest;
use App\Models\evenement;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

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

        if ($request->evenement_id != '' ) {
           
            $evenement=evenement::find($request->evenement_id);
            $rules=[
                'image_ticket'=> 'required',
                'croppedCover'=>'required|string',
                'nom_ticket'=>'required',
                'format'=>'required',
                'prix_ticket'=>'required',
                'place_dispo'=>'required',
                "methodeProgrammationLancement"=>"required",
                "methodeProgrammationFermeture"=>"required",
            ] ;
            if($request->methodeProgrammationLancement=='ProgrammerBilleterie' && ($request->methodeProgrammationFermeture=='FinEvenement'|| $request->methodeProgrammationFermeture=='ProgrammerFermeture')){
                $rules['Date_heure_lancement']="required|after_or_equal:today|before:Date_heure_fermeture|before_or_equal:$evenement->date_heure_fin";
                $rules['Date_heure_fermeture']="required|after_or_equal:Date_heure_lancement|before_or_equal:$evenement->date_heure_fin";
            }elseif (($request->methodeProgrammationLancement=='ProgrammerPlustard'||$request->methodeProgrammationLancement=='ActivationEvènement')&& ($request->methodeProgrammationFermeture=='ProgrammerFermeture'||$request->methodeProgrammationFermeture=='FinEvenement')) {
                $rules['Date_heure_fermeture']="required|before_or_equal:$evenement->date_heure_fin";
            }elseif ($request->methodeProgrammationLancement=='ProgrammerBilleterie' && $request->methodeProgrammationFermeture=='ProgrammerPlustard') {
                $rules['Date_heure_lancement']="required|after_or_equal:today|before_or_equal:$evenement->date_heure_fin";
            }         
            $validateData=$request->validate($rules);
           
            $type_ticket= new type_ticket;
            $croppedCover=$request->croppedCover;
            list($type, $croppedCover) = explode(';', $croppedCover);
            list(, $croppedCover)      = explode(',', $croppedCover);
            $croppedCover = base64_decode($croppedCover);
            $manager = new ImageManager(new Driver());
    
            // Décodage et création de l'image
            $image = $manager->read($croppedCover) ;
        
            // Redimensionnement proportionnel avec une largeur maximale de 800px sans agrandir l'image
            $image = $image->scaleDown(width: 800);
        
            // Encodage de l'image en JPEG avec une qualité de 70%
            $encoded = $image->toJpeg(95); 
               
            $destinationPath=public_path('image_ticket');
            if(!file_exists($destinationPath)){
                mkdir($destinationPath,0775,true);
            }
            $fileName=time(). '_cover_'.$request->nom_evenement;
            $encoded->save($destinationPath.'/'.$fileName);
            $imagePath='image_ticket/' . $fileName;
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
            if($evenement->type_lieu->nom_type=='En ligne'){
                $type_ticket->event_link=$request->event_link;
            }
            $type_ticket->save();
           
            if (url()->previous()!= route('AddTicket', $evenement->id)||session('previousLink')==route('StartWithoutTicket',$evenement->id)) {
                $evenement->Etape_creation=5;
                session()->forget(['previousLink']);
            }
           
            $evenement->save();
            if (url()->previous()!= route('AddTicket', $evenement->id)) {
                session(['type_ticket'=>$type_ticket->id]);
                return redirect()->route("type_ticket.index")->with('message','Ticket créé');
            }else{
                return redirect()->route('AllTickets',$type_ticket->evenement_id)->with('message','Ticket créé');
            }
        }else{
            return redirect()->back()->with('error','une erreur s\'est produite');
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(type_ticket $type_ticket)
    {
         
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
        $rules=[
            "nom_ticket"=>"required",
            "prix_ticket"=>"required|numeric",
            "place_dispo"=>"required|numeric",
            "methodeProgrammationLancement"=>"required",
            "Date_heure_lancement"=>"Date",
            "methodeProgrammationFermeture"=>"required",
            "Date_heure_fermeture"=>"Date",
        ];
        if($request->image_ticket){
            $rules["image_ticket"]="extensions:jpg,png,svg";
            $rules['croppedCover']='required|string';  
        }else{
            $image_ticket=$type_ticket->image_ticket;
        }
        if($request->image_ticket){
            $data=$request->validate($rules);
            $croppedCover=$request->croppedCover;
            // dd($croppedCover);
            list($type, $croppedCover) = explode(';', $croppedCover);
            list(, $croppedCover)      = explode(',', $croppedCover);
            $croppedCover = base64_decode($croppedCover);
            $manager = new ImageManager(new Driver());

            // Décodage et création de l'image
            $image = $manager->read($croppedCover) ;
        
            // Redimensionnement proportionnel avec une largeur maximale de 800px sans agrandir l'image
            $image = $image->scaleDown(width: 800);
        
            // Encodage de l'image en JPEG avec une qualité de 70%
            $encoded = $image->toJpeg(95); 
            
            $destinationPath=public_path('image_ticket');
            if(!file_exists($destinationPath)){
                mkdir($destinationPath,0775,true);
            }
            $fileName=time(). '_cover_'.$request->nom_evenement;
            $encoded->save($destinationPath.'/'.$fileName);
            $imagePath='image_ticket/'. $fileName;
            $data['image_ticket']=$imagePath;
        }else{
            $data['image_ticket']=$image_ticket;
        }
        $type_ticket->update($data);
        return redirect()->route('AllTickets',$type_ticket->evenement_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(type_ticket $type_ticket)
    {
        $evenement_id=$type_ticket->evenement_id;
        $type_ticket->delete();
        return redirect()->route('AllTickets',$evenement_id)->with('message','ticket supprimé');
    }

    public function terminus(){
        session()->forget(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket']);
        return redirect()->route('MesEvenements');
    }

    public function billetterie(){

        $evenements=evenement::all();
        return view('admin.type_ticket.billetterie',compact('evenements'));
    }

    public function AddTicket(evenement $evenement){
        $promoteur_id=auth()->user()->profil_promoteur->id;
        if($evenement->profil_promoteur_id==$promoteur_id ){
            $evenement_id=$evenement->id;
            return view('admin.type_ticket.AddTicket',compact('evenement_id','evenement'));
        }else{
            return redirect()->route('UnauthorizedUser');
        }
    }

    public function AllTickets(evenement $evenement){
        $promoteur_id=auth()->user()->profil_promoteur->id;
        if($evenement->profil_promoteur_id==$promoteur_id ){
            $typeTickets=$evenement->type_tickets;
            return view('admin.type_ticket.AllTickets',compact('typeTickets','evenement'));
        }else{
            return redirect()->route('UnauthorizedUser');
        }

    }
     public function StartWithoutTicket(evenement $evenement){
        session(['previousLink'=>route('StartWithoutTicket',$evenement->id)]);
        return view('admin.type_ticket.startWithoutTickets',compact('evenement'));
     }
}
