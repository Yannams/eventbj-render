<?php

namespace App\Http\Controllers;

use App\Models\chronogramme;
use App\Models\evenement;
use App\Models\Centre_interet;
use App\Http\Requests\StoreevenementRequest;
use App\Http\Requests\UpdateevenementRequest;
use App\Models\Profil_promoteur;
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
use App\Models\Intervenant;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use phpseclib3\Crypt\RSA;
use App\Mail\InfoUser;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use PDOException;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {  
        
            $recommanded_events=evenement::where('recommanded',true)
                                ->where('isOnline', true)
                                ->where('date_heure_fin','>=',now())
                                ->get();
            if(auth()->check()){
            
                if(Auth::user()->centre_interets->count()>0){       
                    $user_id=auth()->user()->id;
                    $user=User::findOrFail($user_id);
                    $Interests=$user->centre_interets()->get();
                    $InterestsIds=$user->centre_interets()->pluck('centre_interet_id');
                    $evenement=evenement::where('isOnline',true)->where('date_heure_fin','>=',now())->whereHas('centre_interets',function($query){
                        $user=User::findOrFail(auth()->user()->id);
                        $InterestsIds=$user->centre_interets()->pluck('centre_interet_id');
                        $InterestArray=$InterestsIds->toArray();
                        $query->whereIn('centre_interet_id',$InterestArray);
                    })->get();
                }else {
                    return redirect()->route('Centre_interet.index');
                }
            }else{
                $Interests=Centre_interet::all();
                $evenement = evenement::where('isOnline', true)
                        ->where('date_heure_fin','>=',now())
                        ->get();
            }
        
            
            $type_evenement=type_evenement::all();
            return view('admin.evenement.index', compact('evenement', 'type_evenement', 'recommanded_events','Interests'));   
       
            
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
        $userId = auth()->user()->Profil_promoteur->id; 
        $evenement=new evenement;
        $validatedData= $request->validate([
            'Frequence'=>'required|min:3|max:10'
        ]);
        $evenement->Fréquence=$request->Frequence;
        $evenement->profil_promoteur_id=$userId;
        $evenement->type_lieu_id=2;
        if($evenement->Etape_creation < 2){
            $evenement->Etape_creation=2;
        }
        $evenement->save();
      
        $evenement_id=$evenement->id;
        session(['TypeLieu'=>$evenement->type_lieu_id]); 
        session(['evenement_id'=>$evenement_id]);
        return redirect()->route('evenement.edit',$evenement);   
    }

    /**
     * Display the specified resource.
     */
    public function show(evenement $evenement){
    
        $evenement=evenement::find($evenement->id);
        $date= new DateTime($evenement->date_heure_debut);
        $promoteur_id=$evenement->profil_promoteur_id;
        $user_id=$evenement->Profil_promoteur->user->id;
        $organisateur=Profil_promoteur::find($promoteur_id);
        $chronogramme=chronogramme::where('evenement_id',$evenement->id)->get();
        $type_tickets= type_ticket::where('evenement_id',$evenement->id)->whereIn('format',['Ticket','Ticket gratuit'])->where('Date_heure_lancement','<=',now())->where('Date_heure_fermeture','>=',now())->get();
        $same_creator=evenement::where('isOnline', true)
                ->where('profil_promoteur_id',$promoteur_id)
                ->where('date_heure_fin','>=',now())
                ->get();
        $user_id=auth()->id();
        $click=$evenement->users()->wherePivot('user_id',$user_id)->wherePivot('evenement_id',$evenement->id)->get();     
        if ($click->isEmpty()) {
            $nombre_click=['nombre_click'=>1,'like'=>false,'date_click'=>now(),'created_at'=>now(),'updated_at'=>now()];
            $evenement->users()->attach($user_id,$nombre_click);
        } 
        $intervenants=Intervenant::where('evenement_id',$evenement->id)
                    ->get();
        return view('admin.evenement.show', compact('evenement', 'date','organisateur','chronogramme', 'type_tickets', 'same_creator','intervenants'));
       
           
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(evenement $evenement, Request $request){
        
       
        if(session('evenement_id')&& session('TypeLieu')){
            $typeLieuId = session('TypeLieu');
            $evenement_id=session('evenement_id');
            $evenement = evenement::find($evenement_id);
            $promoteur=auth()->user()->profil_promoteur->id;
            $EventInterest=$evenement->centre_interets()->pluck('centre_interet_id');
            $EventInterestArray=$EventInterest->toArray();
            if($evenement->profil_promoteur_id==$promoteur){
                $type_evenement=type_evenement::all();
                $interests=Centre_interet::all();
                return view('admin.evenement.edit', compact('evenement','type_evenement', 'typeLieuId','interests','EventInterestArray'));
            }else{
                return redirect()->route('UnauthorizedUser');
            }
        }else{
            return redirect()->route('Create_event');
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateevenementRequest $request, evenement $evenement)
    {
        
        $evenement=evenement::find($evenement->id);
        $rules=[
            'nom_evenement'=>'required|min:1|max:100',
            'type_evenement_id'=>'required',
            'interest'=>'required',
        ];
        if(url()->previous()==route('evenement.edit',$evenement->id)){
            $rules['date_heure_debut']='required|after:today|before:date_heure_fin';
            $rules['date_heure_fin']='required|after:today|after:date_heure_debut';
        }
        if($evenement->cover_event==""||$request->cover_event!="" ||$request->croppedCover!=""){
            $rules['cover_event']='required';
            $rules['croppedCover']='required|string';
        }else{
            $cover_event=$evenement->cover_event;
        }
        $ValidatedData=$request->validate($rules);
        $evenement->nom_evenement=$request->nom_evenement;
        // $evenement->localisation=$request->localisation;
        if(url()->previous()==route('evenement.edit',$evenement->id)){
            $evenement->date_heure_debut=$request->date_heure_debut;
            $evenement->date_heure_fin=$request-> date_heure_fin;
        }
        $evenement->type_evenement_id=$request->type_evenement_id;
        $evenement->isOnline=false;        
        $evenement->description=$request->description;
        $croppedCover=$request->croppedCover;
        if($request->croppedCover){
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
               
            $destinationPath=public_path('image_evenement');
            if(!file_exists($destinationPath)){
                mkdir($destinationPath,0775,true);
            }
            $fileName=time(). '_cover_'.str_replace(' ','_',$request->nom_evenement).'.jpg';
            $encoded->save($destinationPath.'/'.$fileName);
            $imagePath='image_evenement/' . $fileName;
            $evenement->cover_event=$imagePath;
        }else{
            $evenement->cover_event=$cover_event;
        }
       
        if(url()->previous()!=route('EditEvent',$evenement->id)){
            if($evenement->Etape_creation < 3){
                $evenement->Etape_creation=3;  
            }
        } 
        $evenement->save();
        $keyRepoName=hash('sha256',$evenement->id.'_'.$evenement->profil_promoteur->id.'_130125');
        $destinationPath=storage_path("app/keys/$keyRepoName");
       
            if(!file_exists($destinationPath)){
                mkdir($destinationPath,0775,true);
            }
       
            $rsa = RSA::createKey(2048); // Taille de clé recommandée : 2048 ou 4096 bits
            $privateKey = $rsa->toString('PKCS8'); // Clé privée au format PKCS8
            $publicKey = $rsa->getPublicKey()->toString('PKCS8'); // Clé publique

            // Sauvegarder les clés dans des fichiers
        file_put_contents("$destinationPath/private_key.pem", $privateKey);
        file_put_contents("$destinationPath/public_key.pem", $publicKey);

        $interests=$request->interest;
        $EventInterest=$evenement->centre_interets()->pluck('centre_interet_id');
        $EventInterestArray=$EventInterest->toArray();
        foreach($interests as $interest){
            if(!in_array($interest,$EventInterestArray)){
                $evenement->centre_interets()->attach($interest);
            }
        }
       if(url()->previous()!=route('EditEvent',$evenement->id)){
            session(['evenement_nom'=>$evenement->nom_evenement]);
            return redirect()->route('localisation')->with('message', 'évènement créé'); 
       }else{
            return redirect()->route('MesEvenements')->with('message','évènement modifié');
       }   


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(evenement $evenement, Request $request)
    {
       $validatedData=$request->validate([
            'raison'=>'required'
       ]);
        if ($evenement->type_tickets()->whereHas('tickets')->exists()) {
            $subscribers = $evenement->type_tickets()
                ->with('tickets.user')
                ->get()
                ->flatMap(function ($type_ticket) {
                    return $type_ticket->tickets->map(function ($ticket) {
                        return $ticket->user->email;
                    });
                })
                ->unique()
                ->values()
                ->toArray();
           
            $mailData=[
              'subject' => 'Annulation de ' . $evenement->nom_evenement,
                'body' => "
                    Bonjour,

                    Nous venons par ce mail vous informer de l'annulation de l'événement \"{$evenement->nom_evenement}\", 
                    initié par le promoteur \"{$evenement->profil_promoteur->nom}\".

                    Nous tenons à vous rappeler qu'EventBJ agit uniquement en tant qu'intermédiaire entre vous et le promoteur. 
                    Par conséquent, seul le promoteur peut nous autoriser à vous rembourser en mettant à notre disposition les fonds nécessaires.

                    En cas de non-remboursement, seul le promoteur est tenu responsable.

                    Cordialement,
                    L'équipe EventBJ
                ",
            ];
            $attach=[];

            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber)
                ->send(new InfoUser($mailData,$attach));
            }

            $mailPromoteur = [
                'subject' => 'Annulation de ' . $evenement->nom_evenement,
                'body' => "
                    Bonjour {$evenement->profil_promoteur->nom},
                    
                    Nous avons notifié l'annulation de l'événement \"{$evenement->nom_evenement}\".
                    
                    Nous vous rappelons que l'obligation de rembourser aux participants l'intégralité du prix payé en cas 
                    d'annulation de l'événement est une obligation personnelle du représentant légal de l'organisateur.
                    
                    Par ailleurs, nous pourrons procéder aux remboursements après la mise à disposition des fonds nécessaires 
                    par vos soins. 
            
                    Cordialement,  
                    L'équipe EventBJ
                "
            ];
            Mail::to($evenement->profil_promoteur->user->email)
                ->send(new InfoUser($mailPromoteur,$attach));
            
        }
       
        
        $evenement=evenement::find($evenement->id);
        $evenement->etat='Annulé';
        $evenement->isOnline=false;
        $evenement->raison=$validatedData['raison'];
        $evenement->save();
        return redirect()->route('MesEvenements')->with('message', 'Evenement annulé !');
    }

    public function annulation(evenement $evenement){
        return view('admin.evenement.annulerEvent',compact('evenement'));
    }
    public function MyEvents(){
        $user_id=Auth::user()->id;
        $user=User::find($user_id);
        if($user->hasRole('Promoteur')){
            $userId = auth()->user()->id;
            $user = User::with('evenements')->find($userId);
            if ($user) {
                $evenement = $user->Profil_promoteur->evenements->where('etat','!=','Annulé')->sortByDesc('created_at');
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
            $evenement->etat= 'désactivé';
            $evenement->save();
            return response()->json([
                "success"=>true,
                "status"=>false,
                "message"=>"évènement désactivé"
            ]);
          }
        else
        {
            if($evenement->Etape_creation <4){
                $redirectUrl=route('lastEventRedirection',$evenement_id);
                return response()->json([
                    "redirect"=>true,
                    "redirecturl"=>$redirectUrl,
                ]);

            }elseif($evenement->Etape_creation==4){
                if($request->form=="form"){
                    $evenement->isOnline=true;
                    $evenement->etat='publié';
                    $evenement->save();
                    return redirect()->route('MesEvenements')->with('message','évènement mis en ligne');
                }
                $redirectUrl=route('StartWithoutTicket',$evenement->id);
                return response()->json([
                    "redirect"=>true,
                    "redirecturl"=>$redirectUrl,
                ]);
            } elseif($evenement->Etape_creation == 5){
                $typeTicketAProgrammer=array();
                foreach ($evenement->type_tickets as $type_ticket) {
                    if ($type_ticket->Date_heure_lancement==null && $type_ticket->methodeProgrammationLancement=="ActivationEvènement") {
                    $type_ticket_update= type_ticket::find($type_ticket->id);
                    $type_ticket_update->Date_heure_lancement=Carbon::now();
                    $type_ticket_update->save();
                    } 
                    if ($type_ticket->Date_heure_lancement==null && $type_ticket->methodeProgrammationLancement=="ProgrammerPlustard" || $type_ticket->Date_heure_fermeture==null && $type_ticket->methodeProgrammationFermeture=="ProgrammerPlustard") {
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
                }  
                $evenement->isOnline=true;
                $evenement->etat='publié';
                $evenement->save();
                return response()->json([
                    "success"=>true,
                    "status"=>true,
                    "message"=>"évènement mis en ligne"
                ]);
            }
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
    public function filteredByInterests($interest){
        $interest=Centre_interet::find($interest);
        $evenement=$interest->evenements->where('isOnline',true)->where('date_heure_fin','>=',now());
        $recommanded_events=evenement::where('recommanded',true)->get();
        if(auth()->check()){
            $user_id=auth()->user()->id;
            $user=User::find($user_id);
            $Interests=$user->centre_interets()->get();
        }else{
            $Interests=Centre_interet::all();
        }
        return view('admin.evenement.index',compact('evenement','recommanded_events','Interests'));
    }

    public function autres(){
        $recommanded_events=evenement::where('recommanded',true)->get();
        if(auth()->check()){
            $user_id=auth()->user()->id;
            $user=User::find($user_id);
            $Interests=$user->centre_interets()->get();
            $InterestsIds=$user->centre_interets()->pluck('centre_interet_id');
            $evenement=evenement::where('isOnline',true)->where('date_heure_fin','>=',now())->whereHas('centre_interets',function($query){
                $user=User::find(auth()->user()->id);
                $InterestsIds=$user->centre_interets()->pluck('centre_interet_id');
                $InterestArray=$InterestsIds->toArray();
                $query->whereNotIn('centre_interet_id',$InterestArray);
           })->get();
        }else{
            $Interests=Centre_interet::all();
            $evenement = evenement::where('isOnline', true)
                    ->where('date_heure_fin','>=',now())
                    ->get();
        }
      
        
        $type_evenement=type_evenement::all();
        return view('admin.evenement.index', compact('evenement', 'type_evenement', 'recommanded_events','Interests'));   
    }
    

    public function filteredByTypeEvents($type){
        $evenement = evenement::where('isOnline', true)
            ->where('type_evenement_id', $type)
            ->get();
        $type_evenement=type_evenement::all();
        return view('admin.evenement.index', compact('evenement', 'type_evenement')); 
    }
    
    public function Create_event(){
        session()->forget(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket','localisation']);
        if(Auth::user()->hasRole('Promoteur')){
            if(session('Create_new')){
                session()->forget(['Create_new']);
                return view('admin.evenement.create_event');
            }else{
                $lastEvent=Auth::user()->profil_promoteur->evenements()->latest()->first();
                if($lastEvent){
                    if($lastEvent->Etape_creation <5){
                        return redirect()->route('lastEventRedirection',$lastEvent->id);
                    }else{
                        return view('admin.evenement.create_event');
                    }
                }else{
                    return view('admin.evenement.create_event');
                }
            }
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
        if(auth()->user()->hasRole('Admin')){
            $layout='layout.admin';
        }
        elseif(auth()->user()->hasRole('Promoteur')){
            $layout='layout.promoteur';
        }else{
            $layout='layout.utilisateur';
        }
        $evenement=evenement::find($evenement);
        $Color_tab=["#308747","#FBAA0A","#F0343C","#874F30","#0A2FFB"];
        return view('admin.evenement.gererEvent',compact('evenement','Color_tab','layout'));
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
        $DatesVente = array();
        $nombreVendusParSemaineDeCeTicket=array();
        foreach ($type_tickets as $type_ticket) {
           
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
            }elseif($nombreDejour=="billeterie"){
                $Date_lancement=Carbon::parse($type_ticket->Date_heure_lancement);
                $Date_fermeture=Carbon::parse($type_ticket->Date_heure_fermeture);
                $nombreDejour= $Date_lancement->diffInDays( $Date_fermeture) ;
                $ecart=ceil($nombreDejour/7);
                for ($i=$nombreDejour; $i >=0; $i-=$ecart) { 
                    $jourDebut=Carbon::now()->today()->subDays($i)->startOfDay();
                    $jourfin=Carbon::now()->today()->subDays($i-($ecart-1))->endOfDay();
                    $DatesVente[]=date('d/m/Y',strtotime($jourDebut))."-".date('d/m/Y',strtotime($jourfin));
                    $nombreVenduDuJourDeCeTicket=$type_ticket->tickets->where('created_at','>=',$jourDebut)->where('created_at','<=',$jourfin)->count();
                    $nombreVendusParSemaineDeCeTicket[]=$nombreVenduDuJourDeCeTicket;
                }
               dd($DatesVente); 
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

    public function PromoteurShow(evenement $evenement){
        $evenement=evenement::find($evenement->id);
        $date= new DateTime($evenement->date_heure_debut);
        $promoteur_id=$evenement->profil_promoteur_id;
       
        $user_id=$evenement->Profil_promoteur->user->id;
       
        $organisateur=Profil_promoteur::find($promoteur_id);
        $chronogramme=chronogramme::where('evenement_id',$evenement->id)->get();
        $ticket= type_ticket::where('evenement_id',$evenement->id)->get();
        $same_creator=evenement::where('isOnline', true)
                ->where('profil_promoteur_id',$promoteur_id)
                ->get();
        $user_id=auth()->id();
        $click=$evenement->users()->wherePivot('user_id',$user_id)->wherePivot('evenement_id',$evenement->id)->get();     
        if ($click->isEmpty()) {
            $nombre_click=['nombre_click'=>1,'like'=>false,'date_click'=>now(),'created_at'=>now(),'updated_at'=>now()];
            $evenement->users()->attach($user_id,$nombre_click);
        } 
        $intervenants=Intervenant::where('evenement_id',$evenement->id)
                    ->get();
        return view('admin.evenement.PromoteurShow', compact('evenement', 'date','organisateur','chronogramme', 'ticket', 'same_creator','intervenants'));
       
           
    }

    public function GiveUpEventProcess(Request $request){
        $evenement_id=$request->evenement_id;
        $evenement=evenement::find($evenement_id);
        $evenement->delete();
        session()->forget(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket','localisation']);
        // dd(session(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket','localisation']));
        return response()->json([
            "success"=>true,
            "message"=>"Creation de l'evenement abandonne"
        ]);
    }

    public function lastEventRedirection(evenement $evenement){
        $evenement= evenement::find($evenement->id);
        if($evenement->Etape_creation==1){
            session()->forget(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket','localisation']);
            session(['evenement_id'=>$evenement->id]);
        }elseif($evenement->Etape_creation==2){
           session()->forget(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket','localisation']);
            session(['evenement_id'=>$evenement->id,'TypeLieu'=>$evenement->type_lieu_id]);
            
        }elseif($evenement->Etape_creation==3){
           session()->forget(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket','localisation']);
            session(['evenement_id'=>$evenement->id,'TypeLieu'=>$evenement->type_lieu_id,'evenement_nom'=>$evenement->nom_evenement]);
        }elseif($evenement->Etape_creation==4){
           session()->forget(['evenement_id', 'TypeLieu', 'evenement_nom','type_ticket','localisation']);
            session(['evenement_id'=>$evenement->id,'TypeLieu'=>$evenement->type_lieu_id,'evenement_nom'=>$evenement->nom_evenement, 'localisation'=>$evenement->localisation]);
        }
        return view('admin.evenement.lastEventRedirection',compact('evenement'));
    }

    public function UnauthorizedUser(){
        return view('layout.UnauthorizedUser');
    }

    public function localisation(){
        if(session('evenement_id') && session('TypeLieu') && session('evenement_nom')){
            $evenement_id=session('evenement_id');
            $evenement = evenement::find($evenement_id);
            $promoteur=auth()->user()->profil_promoteur->id;
            if($evenement->profil_promoteur_id==$promoteur){
                return view('admin.evenement.localisation',compact('evenement'));
            }else{
                return redirect()->route('UnauthorizedUser');
            }
        }else{
            return redirect()->route('Create_event');
        }
        
       
    }
    
    public function localisationStore(Request $request){
        $evenement_id=session('evenement_id');
        $evenement=evenement::find($evenement_id);
        Validator::extend('google_maps_iframe', function($attribute, $value, $parameters, $validator) {
            // Vérifie si le contenu contient un <iframe> avec une URL Google Maps
            return preg_match('/<iframe.*src="https:\/\/www\.google\.com\/maps\/.*"><\/iframe>/', $value);
        });
        $rules=[
            'localisation'=>'required',
        ];
        if($request->localisation_maps){
            $rules['localisation_maps']='required|google_maps_iframe';
        }
        $ValidatedData=$request->validate($rules);
        $previousLocalisation=$evenement->localisation;
        $evenement->localisation=$request->localisation;
        $evenement->localisation_maps=$request->localisation_maps;
        if(url()->previous()!=route('localisationEdit', $evenement_id)){
            if($evenement->Etape_creation < 4){
                $evenement->Etape_creation=4;
            }
        }
        $evenement->save();
        $participants=User::whereHas('tickets',function($query) use ($evenement_id){
            $query->whereHas('type_ticket',function($query) use ($evenement_id){
                $query->where('evenement_id', $evenement_id);
            });
        })->get();
        if(!empty($participants)){
            $mailData=[
                'subject' => 'Changement de lieu pour ' . $evenement->nom_evenement,
                  'body' => "
                      Bonjour,
    
                      Nous venons par ce mail vous informer du changement lieu de l'événement \"{$evenement->nom_evenement}\", 
                      initié par le promoteur \"{$evenement->profil_promoteur->nom}\" initialement prévu à $previousLocalisation.
                      Le lieu a été déplacé pour celui ci {$evenement->localisation}.
    
                      Cordialement,
                      L'équipe EventBJ
                  ",
              ];
              $attach=[];
    
              foreach ($participants as $subscriber) {
                  Mail::to($subscriber->email)
                  ->send(new InfoUser($mailData,$attach));
              }
        }
        
        if(url()->previous()!=route('localisationEdit', $evenement_id)){
            session(["localisation"=>$evenement->localisation]);
            return redirect()->route('type_ticket.create');
        }else{
            session()->forget(['evenement_id']);
            return redirect()->route('MesEvenements');
        }
    }

    public function EditEvent (evenement $evenement){
        $evenement=evenement::find($evenement->id);
        $promoteur=auth()->user()->profil_promoteur->id;
        $EventInterest=$evenement->centre_interets()->pluck('centre_interet_id');
        $EventInterestArray=$EventInterest->toArray();
        if($evenement->profil_promoteur_id==$promoteur){
            $type_evenement=type_evenement::all();
            $interests=Centre_interet::all();
            return view('admin.evenement.editEvent', compact('evenement','type_evenement','interests','EventInterestArray'));
        }else{
            return redirect()->route('UnauthorizedUser');
        }
    }

    public function LocalisationEdit(evenement $evenement){
        $promoteur_id=auth()->user()->profil_promoteur->id;
        if($evenement->profil_promoteur_id==$promoteur_id){
            session(['evenement_id'=> $evenement->id]);
            return view('admin.evenement.localisationEdit',compact('evenement'));
        }
        else{
            return redirect()->route('UnauthorizedUser');
        }
    }

    public function eventRedirecting(type_ticket $type_ticket, $token){
        $user_id=Auth::user()->id;
        $type_ticket_id=$type_ticket->id;
        $ExpectedToken=hash('sha256', $user_id . $type_ticket_id . config('app.key'));
        //$token=$_GET['token'];
        if($token== $ExpectedToken){
           return view('admin.evenement.OnlineEvent',compact('type_ticket'));
        }
    }

    public function ReportEvent(evenement $evenement){
        return view('admin.evenement.ReportEvent',compact('evenement'));
    }

    public function ExecuteReport(Request $request){
        $validatedData=$request->validate([
            'evenement_id'=>'required',
            'date_heure_debut'=>'required|after:today|before:date_heure_fin',
            'date_heure_fin'=>'required|after:today|after:date_heure_debut',
        ]);
        $evenement_id=$request->evenement_id;
        $evenement=evenement::find($evenement_id);
        if($evenement->profil_promoteur_id==auth()->user()->Profil_promoteur->id){
            $previousStartDay= $evenement->date_heure_debut;
            $previousEndDay= $evenement->date_heure_fin;
            $evenement->date_heure_debut=$request->date_heure_debut;
            $evenement->date_heure_fin=$request->date_heure_fin;
            $evenement->save();
            $participants=User::whereHas('tickets',function($query) use ($evenement_id){
                $query->whereHas('type_ticket',function($query) use ($evenement_id){
                    $query->where('evenement_id', $evenement_id);
                });
            })->get();
            $mailData=[
                'subject' => 'Report de ' . $evenement->nom_evenement,
                  'body' => "
                      Bonjour,
  
                      Nous venons par ce mail vous informer du report de l'événement \"{$evenement->nom_evenement}\", 
                      initié par le promoteur \"{$evenement->profil_promoteur->nom}\" initialement prévu pour débuter 
                      le {$previousStartDay} et terminer le {$previousEndDay}.
  
                      Il aura lieu le ".date('d/m/Y à H:i',strtotime($evenement->date_heure_debut))."
                      et prendra fin le ".date('d/m/Y à H:i',strtotime($evenement->date_heure_debut))."

                      Cordialement,
                      L'équipe EventBJ
                  ",
              ];
              $attach=[];
  
              foreach ($participants as $subscriber) {
                  Mail::to($subscriber->email)
                  ->send(new InfoUser($mailData,$attach));
              }
            return redirect()->route('MesEvenements')->with('message','évènement reporté');
        }else{
            return redirect()->route('UnauthorizedUser');   
        }
    }
}