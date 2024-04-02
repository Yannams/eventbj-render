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
        $evenement->date_heure_fin=$request->date_heure_fin;
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

            $userId = auth()->user()->id;
            $user = User::with('evenements')->find($userId);
            if ($user) {
                $evenement = $user->evenements->sortByDesc('created_at');
                return view("admin.evenement.mesEvenements", compact("evenement"));
            } else {
                return view("admin.evenement.mesEvenements", compact("evenement"))->with('problème','aucun évènement n\'a été trouvé');
            }
       
    }  
    
    public function OnlineEvents(Request $request){
        $evenement_id= $request->evenement_id;
        $evenement=evenement::find( $evenement_id );
        if($evenement->isOnline==false){
            $evenement->isOnline=true;
            $evenement->save();
            return response()->json([
                "success"=>true,
                "status"=>true,
                "message"=>"evenement mis en ligne",
            ]);
        }
        else
        {
            $evenement->isOnline=false;
            $evenement->save();
            return response()->json([
                "success"=>true,
                "status"=>false,
                "message"=>"evenement désactivé"
            ]);
        }
       
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
        $evenement=evenement::where('nom_evenement', 'like', '%'.$keyWord.'%')->get();
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

        $evenement_id=$request->evenement_id;
        $evenement=evenement::find($evenement_id);
        $type_tickets=$evenement->type_tickets;

        //obtenir les donnée des statistique de ventes de tickets
        $nom_ticket_tab=array();
        $nombreTicket_tab=array();
        foreach ($type_tickets as $type_ticket) {
           $nom_ticket=$type_ticket->nom_ticket;
           $nombreTicket=$type_ticket->tickets->count();
           $nom_ticket_tab[]=$nom_ticket;
           $nombreTicket_tab[]=$nombreTicket;
        }
        
        // obtenir les données des ventes par semaines
        $WeeklySells=array();
        $dailyData=array();
        $data=array();
        $borderColor_tab=["#308747","#FBAA0A","#F0343C"];
        $borderColor=array();
        $x=0;
       foreach ($type_tickets as  $type_ticket) {
            for($i=0; $i<7;$i++){
                $jour = Carbon::now()->startOfWeek()->addDays($i); // Jour de la semaine spécifié

                $nbInstancesJour = $type_ticket->tickets()->whereDate('created_at', $jour)->count();

                $dailyData[$i]=$nbInstancesJour;
            }
            $data[$type_ticket->nom_ticket]=$dailyData;
            $borderColor[$type_ticket->nom_ticket]=$borderColor_tab[$x];  
            $x++;
        }
        foreach($nom_ticket_tab as $nom_ticket){

            $WeeklySells_content=[
                "label"=>$nom_ticket,
                "data"=>$data[$nom_ticket],
                "borderColor"=>$borderColor[$nom_ticket]
            ];

            $WeeklySells[]=$WeeklySells_content;

        }

        //obtenir l'evolution du revenu 
      $revenuParTicket=array();
      $revenuJournalier=array();
       foreach ($type_tickets as $type_ticket) {
            for ($i=0; $i < 7; $i++) { 
                $jour = Carbon::now()->startOfWeek()->addDays($i); 
                $nbInstancesJour = $type_ticket->tickets()->whereDate('created_at', $jour)->count();
                $dailyData[$i]=$nbInstancesJour;
            }  
           
            foreach ($dailyData as $nbrTicket) {
                $prixTicket=$nbrTicket*$type_ticket->prix_ticket;
                $revenuJournalier[]=$prixTicket;
            }
            $revenuParTicket[]=$revenuJournalier;
            $revenuJournalier=array();
       } 
       
       $revenuSemestriel=array(0,0,0,0,0,0,0);
      for ($i=0; $i < count($revenuParTicket); $i++) { 
            for ($j=0; $j < count($revenuParTicket[$i]); $j++) { 
                $revenuSemestriel[$j] += $revenuParTicket[$i][$j];
            }
        }
     
      //nombre de click
     $clickPerweek=array();
        for ($i=0; $i < 7; $i++) { 
            $jour = Carbon::now()->addDays($i);
            $clickPerDay=$evenement->users()->wherePivot('Date_click','>=',$jour->startOfDay()->toDateTimeString())->wherePivot('Date_click','<=',$jour->endOfDay()->toDateTimeString())->count();
            $clickPerweek[]=$clickPerDay;
        }  
    
       //evolution du nombre d'incrit
        $nombreTicketPerDay=array(0,0,0,0,0,0,0);
       foreach ($type_tickets as $type_ticket) {
            for ($i=0; $i < count($data[$type_ticket->nom_ticket]); $i++) { 
                $nombreTicketPerDay[$i]+=$data[$type_ticket->nom_ticket][$i];
            }
       }
       	//calcul du taux de conversion
        $WeeklyConversion=array();
       for ($i=0; $i < 7; $i++) { 
        if ($nombreTicketPerDay[$i]!=0) {
            $conversionPerDay=($clickPerweek[$i]/$nombreTicketPerDay[$i])*100;
        }
        else{
            $conversionPerDay=0;
        }

            $WeeklyConversion[]=$conversionPerDay;
       }
        
      
        return response()->json([
            "type_ticket"=>$nom_ticket_tab,
            "nombreTicket"=>$nombreTicket_tab,
            "datasells"=>$WeeklySells,
            "evolution_revenu"=>$revenuSemestriel,
            "evolution_click"=>$clickPerweek,
            "evolution_inscription"=>$nombreTicketPerDay,
            "ConversionPerDay"=>$WeeklyConversion
        ]);
    }
}


