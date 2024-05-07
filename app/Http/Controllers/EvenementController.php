<?php

namespace App\Http\Controllers;

use App\Models\chronogramme;
use App\Models\evenement;
use App\Http\Requests\StoreevenementRequest;
use App\Http\Requests\UpdateevenementRequest;
use App\Models\type_evenement;
use App\Models\type_lieu;
use App\Models\type_ticket;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ticket;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {  
        $evenement = evenement::where('isOnline', true)
                    ->get();
        $type_evenement=type_evenement::all();
        return view('admin.evenement.index', compact('evenement', 'type_evenement'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
        $typeLieuId = $request->query('type_lieu_event');
        $type_evenement=type_evenement::all();
        session(['type_lieu'=>$typeLieuId]);
        return view('admin.evenement.create', compact('typeLieuId','type_evenement'));
        
     
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreevenementRequest $request):RedirectResponse
    {
       
        $userId = auth()->user()->id;
        $evenement=new evenement;
        $validatedData= $request->validate([
            'Frequence'=>'required|min:3|max:10'
        ]);
        $evenement->Fréquence=$request->Frequence;
        $evenement->user_id=$userId;
        $evenement->save();
        $evenement_id=$evenement->id;
        session(['evenement_id'=>$evenement_id]);
        return redirect()->route('select_type_lieu');   
    }

    /**
     * Display the specified resource.
     */
    public function show(evenement $evenement){
        
        $evenement=evenement::find($evenement->id);
        $date= new DateTime($evenement->date_heure_debut);
        $user_id=$evenement->user_id;
        $organisateur=User::find($user_id);
        $chronogramme=chronogramme::where('evenement_id',$evenement->id)->get();
        $ticket= type_ticket::where('evenement_id',$evenement->id)->get();
        $same_creator=evenement::where('isOnline', true)
                ->where('user_id',$user_id)
                ->get();
        $user_id=auth()->id();
        $click=$evenement->users()->wherePivot('user_id',$user_id)->wherePivot('evenement_id',$evenement->id)->get();     
        if ($click->isEmpty()) {
            $nombre_click=['nombre_click'=>1,'like'=>false,'date_click'=>now(),'created_at'=>now(),'updated_at'=>now()];
            $evenement->users()->attach($user_id,$nombre_click);
        } 
        return view('admin.evenement.show', compact('evenement', 'date','organisateur','chronogramme', 'ticket', 'same_creator'));
       
           
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(evenement $evenement, Request $request){
        $typeLieuId = $request->query('type_lieu_event');
        $type_evenement=type_evenement::all();
        return view('admin.evenement.edit', compact('evenement','type_evenement', 'typeLieuId'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateevenementRequest $request, evenement $evenement)
    {
       
        $evenement=evenement::find($evenement->id);
        $ValidatedData=$request->validate([
            'nom_evenement'=>'required|min:1|max:100',
            'localisation'=>'required',
            'date_heure_debut'=>'required|after:today|before:date_heure_fin',
            'date_heure_fin'=>'required|after:today|after:date_heure_debut',
            'type_evenement_id'=>'required'
        ]);
        $evenement->nom_evenement=$request->nom_evenement;
        $evenement->localisation=$request->localisation;
        $evenement->date_heure_debut=$request->date_heure_debut;
        $evenement->date_heure_fin=$request-> date_heure_fin;
        $evenement->type_evenement_id=$request->type_evenement_id;
        $evenement->isOnline=false;        
        $evenement->description=$request->description;
        if($request->hasFile('cover_event'))
        {
            $image = $request->file('cover_event');
            $destinationPath = public_path('image_evenement'); // Le chemin de destination où vous souhaitez déplacer le fichier

            // Assurez-vous que le répertoire de destination existe
            if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0755, true);
            }
    
            $fileName = time() . '_' . $image->getClientOriginalName(); // Générez un nom de fichier unique si nécessaire
    
            $image->move($destinationPath, $fileName); // Déplacez le fichier vers le répertoire de destination
    
            // Maintenant, $destinationPath.'/'.$fileName contient le chemin complet du fichier déplacé
            $imagePath='image_evenement/'.$fileName;
            $evenement->cover_event = $imagePath;
        } 
        else
        {
            $defaultImagePath = 'image/concert.jpeg';
            $evenement->cover_event=$defaultImagePath;
        }
        $typelieu=$request->input('type_lieu_selected');
        $evenement->type_lieu_id=$typelieu;      
        $evenement->save();
        session(['evenement_nom'=>$evenement->nom_evenement]);
        return redirect()->route('type_ticket.create')->with('message', 'evenement créé');    

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(evenement $evenement)
    {
        $evenement->delete();
        return redirect()->route('MesEvenements')->with('danger', 'Evenement supprimé !');
    }
    public function MyEvents(){
        if(Auth::user()->hasRole('Promoteur')){
            $userId = auth()->user()->id;
            $user = User::with('evenements')->find($userId);
            if ($user) {
                $evenement = $user->evenements->sortByDesc('created_at');
                return view("admin.evenement.mesEvenements", compact("evenement"));
            } else {
                return view("admin.evenement.mesEvenements", compact("evenement"))->with('problème','aucun évènement n\'a été trouvé');
            }
        }
        else {
            session(['route'=>'MesEvenements']);
            return redirect()->route('Promoteur.create');
        }
       
    }  
    
    public function OnlineEvents(Request $request){
        $evenement_id= $request->evenement_id;
        $evenement=evenement::find( $evenement_id );
        
        /*
        *Je vérifie d'abord que tous les tickets d'un évènements ont une date de lancement et un date de fermeture
        *Si la date de lancement est nulles et que la méthode est ActivationEvènement je met la date du jour
        *Si les deux dates sont nulle le rediriger vers un endroit ou il pourra changer la date
        *Si rien n'est null mettre l'evènement en ligne 
         */
        
        if($evenement->isOnline==true){
            $evenement->isOnline=false;
            $evenement->save();
            return response()->json([
                "success"=>true,
                "status"=>false,
                "message"=>"evenement désactivé"
            ]);
          }
        else
        {
            $typeTicketAProgrammer=array();
            foreach ($evenement->type_tickets as $type_ticket) {
                if ($type_ticket->Date_heure_lancement==null && $type_ticket->methodeProgrammationLancement=="ActivationEvènement") {
                   $type_ticket_update= type_ticket::find($type_ticket->id);
                   $type_ticket_update->Date_heure_lancement=Carbon::now();
                   $type_ticket_update->save();
                } elseif ($type_ticket->Date_heure_lancement==null && $type_ticket->methodeProgrammationLancement=="ProgrammerPlustard" || $type_ticket->Date_heure_fermeture==null && $type_ticket->methodeProgrammationFermeture=="ProgrammerPlustard") {
                    $typeTicketAProgrammer[]=$type_ticket->id;
                    $redirectUrl=route('ModifierHoraire');
                }
                
            }
            if(!empty($typeTicketAProgrammer)){
               
                session(['type_ticket'=>$typeTicketAProgrammer]);
                
                return response()->json([
                    "redirect"=>true,
                    "redirecturl"=>$redirectUrl,
                    "Type_ticket"=>$typeTicketAProgrammer
                ]);
            }  $evenement->isOnline=false;
            $evenement->save();
            return response()->json([
                "success"=>true,
                "status"=>true,
                "message"=>"evenement désactivé"
            ]);
            
        
        }
       
    }
    public function ModifierHoraire(){
        $typeTicketAprogrammer=array();
        $typeTicket=session('type_ticket');
        foreach ($typeTicket as $key => $typeTicketArecuperer) {
           $typeTicketAprogrammer[]=type_ticket::find($typeTicketArecuperer);
        }
        
        return view('admin.type_ticket.modifierHoraire',compact('typeTicketAprogrammer'));
    }

    public function UpdateHoraire(Request $request){

       $typeTicketsAmodifier=session('type_ticket');
    //    dd($typeTicketsAmodifier, $request);
       foreach ($typeTicketsAmodifier as $key => $typeTicketAmodifier) {

          $TypeTicket=type_ticket::find($typeTicketAmodifier);
          $evenement=evenement::find($TypeTicket->evenement->id);
          $evenement->isOnline=true;
          $evenement->save();
          if($request->methodeProgrammationLancement[$typeTicketAmodifier]=='ActivationEvènement'){
                $TypeTicket->Date_heure_lancement=now();
          }else{
              $TypeTicket->Date_heure_lancement=$request->Date_heure_lancement[$typeTicketAmodifier];
          }
          $TypeTicket->methodeProgrammationLancement=$request->methodeProgrammationLancement[$typeTicketAmodifier];
          $TypeTicket->methodeProgrammationFermeture=$request->methodeProgrammationFermeture[$typeTicketAmodifier];
          $TypeTicket->Date_heure_fermeture=$request->Date_heure_fermeture[$typeTicketAmodifier];
          $TypeTicket->save();
        

       }
       return redirect()->route('MesEvenements')->with('message','évènement mis en ligne');

    

    }

    public function filteredByTypeEvents($type){
      
            $evenement = evenement::where('isOnline', true)
                ->where('type_evenement_id', $type)
                ->get();
        $type_evenement=type_evenement::all();
        return view('admin.evenement.index', compact('evenement', 'type_evenement'));
       
        
    }
    public function Create_event(){
        session()->forget(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket']);
        if(Auth::user()->hasRole('Promoteur')){
            return view('admin.evenement.create_event');
        }else{
            session(['route'=>'Create_event']);
            return redirect()->route('Promoteur.create'); 
        }
       
    }
    
    public function like_event(Request $request){
        $user_id=Auth::user()->id;
        $evenement_id=$request->evenement_id;
        $evenement = evenement::find($evenement_id);
        $like=$evenement->users()->wherePivot('user_id',$user_id)->wherePivot('evenement_id',$evenement_id)->wherePivot('like',true);
        $get_likeline=$like->get();
        
        if($evenement->users()->wherePivot('user_id',$user_id)->wherePivot('evenement_id',$evenement_id)->wherePivot('like',true)->get()->isNotEmpty()){
            $status=['like'=>false,'date_unlike'=>now(),'updated_at'=>now()];
            $evenement->users()->updateExistingPivot($user_id,$status);
           
        }elseif($evenement->users()->wherePivot('user_id',$user_id)->wherePivot('evenement_id',$evenement_id)->wherePivot('like',false)->get()->isNotEmpty()){
            $status=['like'=>true,'date_like'=>now(),'updated_at'=>now()];
            $evenement->users()->updateExistingPivot($user_id,$status);
        }else{
            $status=['like'=>true,'nombre_click'=>0,'date_like'=>now(),'created_at'=>now(),'updated_at'=>now()];
            $evenement->users()->attach($user_id,$status);
        }

    }

    public function research_event(Request $request){
        $keyWord=$request->search;
        $evenement=evenement::where('nom_evenement', 'like', '%'.$keyWord.'%')->where('isOnline',true)->get();
        //dd($evenement);
        if ($evenement) {
            return response()->json([
                "success"=>true,
                "evenement"=>$evenement
            ]);
        }
        else {
            return response()->json([
                "success"=>false,
                "message"=>"Aucun évènement pour le moment"
            ]);
        }
       
    }

    public function gererEvent($evenement){
        $evenement=evenement::find($evenement);
        $Color_tab=["#308747","#FBAA0A","#F0343C"];
        return view('admin.evenement.gererEvent',compact('evenement','Color_tab'));
    }

     public function getChartsData(Request $request){
        //récupérer l'évènement
        $evenement=evenement::find($request->evenement_id);
        
        /*récupérer tous les types de ticket de cet evènement pour comparer les ventes */
        $type_tickets=$evenement->type_tickets()->get();

        //recupération des périodes
        $periode=$request->periode;
        $periode_revenu=$request->periode_revenu;
        $periode_click=$request->periode_click;
        $periode_inscription=$request->periode_inscription;
        $periode_conversion=$request->periode_conversion;
       
        //nombre de ticket  vendu par type_ticket
        $nombreTicketParTypeticket=array();
        $NomTypeTicket = array();
        foreach ($type_tickets as $type_ticket) {
            $nombreTicket=$type_ticket->tickets->count();
            $nombreTicketParTypeticket[]=$nombreTicket;
            $NomTypeTicket[]=$type_ticket->nom_ticket;

        }

    


        $nombreDejour=$periode;
        $NombreVenduParTicket=array();
        $Color=["#308747","#FBAA0A","#F0343C"];
        $borderColor=array();
        $x=0;
        
        foreach ($type_tickets as $type_ticket) {
            $DatesVente = array();
            $nombreVendusParSemaineDeCeTicket=array();
            // Je récupère le nombre de ticket vendu selon le jour
            if ($nombreDejour==7){
                for ($i=$nombreDejour-1; $i >=0 ; $i--) { 
                    $jour=Carbon::now()->today()->subDays($i);
                    $DatesVente[]=date('d/m/Y',strtotime($jour));
                    $nombreVenduDuJourDeCeTicket=$type_ticket->tickets->where('created_at','>=',$jour->startOfDay())->where('created_at','<=',$jour->endOfDay())->count();
                    $nombreVendusParSemaineDeCeTicket[]=$nombreVenduDuJourDeCeTicket;
                }
            } elseif ($nombreDejour==30) {
                for ($i=27; $i >=0; $i-=4) { 

                    $jourDebut=Carbon::now()->today()->subDays($i)->startOfDay();
                    $jourfin=Carbon::now()->today()->subDays($i-3)->endOfDay();
                    $DatesVente[]=date('d/m/Y',strtotime($jourDebut))."-".date('d/m/Y',strtotime($jourfin));
                    $nombreVenduDuJourDeCeTicket=$type_ticket->tickets->where('created_at','>=',$jourDebut)->where('created_at','<=',$jourfin)->count();
                    $nombreVendusParSemaineDeCeTicket[]=$nombreVenduDuJourDeCeTicket;
                }
            }
            
            $NombreVenduParTicket[$type_ticket->nom_ticket]=$nombreVendusParSemaineDeCeTicket;
            $borderColor[$type_ticket->nom_ticket]=$Color[$x];
            $x++;
        }

        //Création de la datasets à envoyer pour les ticket 
        foreach($NomTypeTicket as $nom_ticket){

            $WeeklySells_content=[
                "label"=>$nom_ticket,
                "data"=>$NombreVenduParTicket[$nom_ticket],
                "borderColor"=>$borderColor[$nom_ticket]
            ];

            $WeeklySells[]=$WeeklySells_content;

        }

        //revenu
        //l'evolution du revenu c'est l'evolution du chiffre d'affaire par jour pour tous les ticket

        
         $revenuParTicket=array();
        $revenuJournalier=array();
    
       foreach ($type_tickets as $type_ticket) {
        //recupérer le nombre de ticket vendu par jours
        $Date_Revenus=array();
        $revenuPourCeTicket=array();
        if($periode_revenu==7){
            for($i=$periode_revenu-1 ; $i>=0 ;$i--){
                $jour=Carbon::now()->today()->subDays($i);
                $Date_Revenus[]=date('d/m/Y',strtotime($jour));
                $nombreTicket=$type_ticket->tickets->where('created_at','>=',$jour->startOfDay())->where('created_at','<=',$jour->endOfDay())->count();
                $revenuPourCeTicket[]=$nombreTicket*$type_ticket->prix_ticket;
            }
        }elseif($periode_revenu==30){
           for ($i=27; $i >=0 ; $i-=4) { 
                $jourDebut=Carbon::now()->today()->subDays($i)->startOfDay();
                $jourfin=Carbon::now()->today()->subDays($i-3)->endOfDay();
                $Date_Revenus[]=date('d/m/Y',strtotime($jourDebut))."-".date('d/m/Y',strtotime($jourfin));
                $nombreTicket=$type_ticket->tickets->where('created_at','>=',$jourDebut)->where('created_at','<=',$jourfin)->count();
                $revenuPourCeTicket[]=$nombreTicket*$type_ticket->prix_ticket;
           }
        }
        $revenuParTicket[]=$revenuPourCeTicket;
       }
        
       $revenuSemestriel=array(0,0,0,0,0,0,0);
       for ($i=0; $i < count($revenuParTicket) ; $i++) { 
            for ($j=0; $j < count($revenuParTicket[$i]); $j++) { 
                $revenuSemestriel[$j] += $revenuParTicket[$i][$j];
                
            }
       }
       
       //Nombre de click
       $Date_click=array();
       $NbrClickParDate=array();
       if ($periode_click==7) {
        for ($i=$periode_click-1; $i>=0 ; $i--) { 
            $jour=Carbon::now()->today()->subDays($i);
            $debutjour=Carbon::now()->today()->subDays($i)->startOfDay();
            $finjour=Carbon::now()->today()->subDays($i)->endOfDay();
            $NombreClickAcetteDate = $evenement->users()->wherePivot('Date_click','>=',$debutjour)->wherePivot('Date_click','<=',$finjour)->count();
            $Date_click[]=date('d/m/Y',strtotime($jour));
            $NbrClickParDate[]=$NombreClickAcetteDate;
        }
       }elseif ($periode_click==30) {
        for ($i=27; $i>=0 ; $i-=4) { 
            //$jour=Carbon::now()->today()->subDays($i);
            $debutjour=Carbon::now()->today()->subDays($i)->startOfDay();
            $finjour=Carbon::now()->today()->subDays($i-3)->endOfDay();
            $NombreClickAcetteDate = $evenement->users()->wherePivot('Date_click','>=',$debutjour)->wherePivot('Date_click','<=',$finjour)->count();
            $Date_click[]=date('d/m/Y',strtotime($debutjour))."-".date('d/m/Y',strtotime($finjour));
            $NbrClickParDate[]=$NombreClickAcetteDate;
           
        }
    }
       
      

    //Nonmbre d'inscriptionn
   $NombreInsriptionParTicket=array();
    foreach ($type_tickets as $type_ticket) {
        //recupérer le nombre de ticket vendu par jours
        $Date_inscription=array();
        $NbrInscriptionPourCeTicket=array();
        if ($periode_inscription==7) {
            for($i=$periode_inscription-1 ; $i>=0 ;$i--){
                $jour=Carbon::now()->today()->subDays($i);
                $Date_inscription[]=date('d/m/Y',strtotime($jour));
                $nombreTicket=$type_ticket->tickets->where('created_at','>=',$jour->startOfDay())->where('created_at','<=',$jour->endOfDay())->count();
                $NbrInscriptionPourCeTicket[]=$nombreTicket;
            }
        }elseif ($periode_inscription==30) {
            for($i=27 ; $i>=0 ;$i-=4){
                $jourDebut=Carbon::now()->today()->subDays($i)->startOfDay();
                $jourfin=Carbon::now()->today()->subDays($i-3 )->endOfDay();
                $Date_inscription[]=date('d/m/Y',strtotime($jourDebut))."-".date('d/m/Y',strtotime($jourfin));
                $nombreTicket=$type_ticket->tickets->where('created_at','>=',$jourDebut)->where('created_at','<=',$jourfin)->count();
                $NbrInscriptionPourCeTicket[]=$nombreTicket;
            }
        }
       
        $NombreInscriptionParTicket[]=$NbrInscriptionPourCeTicket;
       }
       
       $InscriptionJournalier=array(0,0,0,0,0,0,0);
       for ($i=0; $i < count($NombreInscriptionParTicket) ; $i++) { 
            for ($j=0; $j < count($NombreInscriptionParTicket[$i]); $j++) { 
                $InscriptionJournalier[$j] += $NombreInscriptionParTicket[$i][$j];  
            }
       }
       
       //obtenir le taux de conversion journalier 
       
       //recupérer le tableau des incription pour la conversion
    
       $NombreInsriptionParTicketConversion=array();
    foreach ($type_tickets as $type_ticket) {
        //recupérer le nombre de ticket vendu par jours
        $Date_conversion=array();
        $NbrInscriptionPourCeTicketConversion=array();
        if ($periode_conversion==7) {
            for($i=$periode_conversion-1 ; $i>=0 ;$i--){
                $jour=Carbon::now()->today()->subDays($i);
                $Date_conversion[]=date('d/m/Y',strtotime($jour));
                $nombreTicketConversion=$type_ticket->tickets->where('created_at','>=',$jour->startOfDay())->where('created_at','<=',$jour->endOfDay())->count();
                $NbrInscriptionPourCeTicketConversion[]=$nombreTicketConversion;
            }
        }elseif ($periode_conversion==30) {
            for($i=27 ; $i>=0 ;$i-=4){
                $jourDebut=Carbon::now()->today()->subDays($i)->startOfDay();
                $jourfin=Carbon::now()->today()->subDays($i-3 )->endOfDay();
                $Date_conversion[]=date('d/m/Y',strtotime($jourDebut))."-".date('d/m/Y',strtotime($jourfin));
                $nombreTicketConversion=$type_ticket->tickets->where('created_at','>=',$jourDebut)->where('created_at','<=',$jourfin)->count();
                $NbrInscriptionPourCeTicketConversion[]=$nombreTicketConversion;
            }
        }
        
        $NombreInscriptionParTicketConversion[]=$NbrInscriptionPourCeTicketConversion;
       }
       
       $InscriptionJournalierConversion=array(0,0,0,0,0,0,0);
       for ($i=0; $i < count($NombreInscriptionParTicketConversion) ; $i++) { 
            for ($j=0; $j < count($NombreInscriptionParTicketConversion[$i]); $j++) { 
                $InscriptionJournalierConversion[$j] += $NombreInscriptionParTicketConversion[$i][$j];  
            }
       }

    //recupérer le nombre de click pour la conversion

    $Date_conversion=array();
    $NbrClickParDateConversion=array();
    if ($periode_conversion==7) {
        for ($i=$periode_conversion-1; $i>=0 ; $i--) { 
            $jour=Carbon::now()->today()->subDays($i);
            $debutjour=Carbon::now()->today()->subDays($i)->startOfDay();
            $finjour=Carbon::now()->today()->subDays($i)->endOfDay();
            $NombreClickAcetteDateConversion = $evenement->users()->wherePivot('Date_click','>=',$debutjour)->wherePivot('Date_click','<=',$finjour)->count();
            $Date_conversion[]=date('d/m/Y',strtotime($jour));
            $NbrClickParDateConversion[]=$NombreClickAcetteDateConversion;
        }
    } elseif ($periode_conversion==30) {
        for ($i=27; $i>=0 ; $i-=4) { 
            $debutjour=Carbon::now()->today()->subDays($i)->startOfDay();
            $finjour=Carbon::now()->today()->subDays($i-3)->endOfDay();
            $NombreClickAcetteDateConversion = $evenement->users()->wherePivot('Date_click','>=',$debutjour)->wherePivot('Date_click','<=',$finjour)->count();
            $Date_conversion[]=date('d/m/Y',strtotime($debutjour))."-".date('d/m/Y',strtotime($finjour));
            $NbrClickParDateConversion[]=$NombreClickAcetteDateConversion;
        }
    }
    
   

        $TauxConversionParJour=array();
        
            for ($i=0; $i < 7; $i++) { 
                if ($InscriptionJournalierConversion[$i]!=0) {
                    $TauxConversion=($NbrClickParDateConversion[$i]/$InscriptionJournalierConversion[$i])*100;
                }
                else{
                    $TauxConversion=0;
                }
        
                $TauxConversionParJour[]=$TauxConversion;
            }
        

        
       
        return response()->json([
            'nombreTicketParTypeticket'=>$nombreTicketParTypeticket,
            'type_ticket'=>$NomTypeTicket,
            'dates'=>$DatesVente,
            'datasells'=>$WeeklySells,
            'evolution_revenu'=>$revenuSemestriel,
            'date_revenu'=>$Date_Revenus,
            'date_click'=>$Date_click,
            'evolution_click'=>$NbrClickParDate,
            'date_inscription'=>$Date_inscription,
            'evolution_inscription'=>$InscriptionJournalier,
            'taux_conversion'=>$TauxConversionParJour,
            'date_conversion'=>$Date_conversion,
           
            
            
        ]);
    }
}


