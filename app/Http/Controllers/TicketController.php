<?php

namespace App\Http\Controllers;

use App\Mail\InfoUser;
use App\Models\ticket;
use App\Http\Requests\StoreticketRequest;
use App\Http\Requests\UpdateticketRequest;
use App\Models\evenement;
use App\Models\tickets_verifications;
use App\Models\type_ticket;
use App\Models\User;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use PhpParser\Node\Stmt\Foreach_;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use phpseclib3\Crypt\RSA;
use PHPUnit\Framework\Attributes\Ticket as AttributesTicket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=User::with('tickets')->find(Auth::id());
        $ticket=$user->tickets;
        
        return view('admin.ticket.index', compact('ticket'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type_ticket_id=session('ticket_id');
        $type_ticket = type_ticket::find($type_ticket_id);
        return view('admin.ticket.create',compact('type_ticket'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( StoreticketRequest $request)
    {
        if(auth()->check()){
            
            
            $nombreTicket=$request->nbr;
            $type_ticket=type_ticket::find($request->id_type_ticket);
            $cover_ticket=$type_ticket->image_ticket;
            $attach=array();
            
       
            for($i=0; $i<$nombreTicket; $i++){
                $user=auth()->user()->id;
                $userdata=User::find($user);
                $evenement=$type_ticket->evenement;
                $evenement_id=$evenement->id;
                $promoteur_id=$evenement->profil_promoteur->id;
                $keyRepoName=hash('sha256',$evenement->id.'_'.$evenement->profil_promoteur->id.'_130125');
                $KeyDir=storage_path("app/keys/$keyRepoName/private_key.pem");
                $privateKey=RSA::loadPrivateKey(file_get_contents($KeyDir));

                $ticket = new Ticket;
                $ticket->transaction_id=$request->transaction_id;
                $ticket->type_ticket_id=$request->id_type_ticket;
                $ticket->statut="activé";
                $ticket->user_id=$user;
                $ticket->save();  
                $data=json_encode([
                    "ticket_id"=> $ticket->id,
                    "user_id"=> $ticket->user_id, 
                    "evenement_id"=>$ticket->type_ticket->evenement_id,
                ]);
                $ticket->signature=base64_encode($privateKey->sign($data)); 
                $ticket->save();          
               
                if($type_ticket->evenement->type_lieu->nom_type =="physique"){
                    $codeQRContent = json_encode([
                        "signature"=>$ticket->signature
                    ]);
                    
                    $folderPath = public_path('code_QR');
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    $fileName = uniqid() . '.svg';
                    $filePath = $folderPath . '/' . $fileName;
                    QrCode::format('svg')->generate($codeQRContent,$filePath);
                    $QrCodePath='code_QR/'.$fileName;
                    $ticket->code_QR = $QrCodePath; // Correction ici, utilisez $filePath au lieu de $qrCodePath
                    $ticket->save(); 
                    $data = $ticket; // Récupérer les données pour le PDF
                    $type_ticket->place_dispo--;
                    $type_ticket->save();
                    // Génération du contenu HTML
                    $html = view('admin.ticket.generatedTicket',compact('data'));

                    // Initialisation de Dompdf (via le fournisseur de service)
                    $dompdf = app(Dompdf::class);

                    // Chargement du contenu HTML
                    $dompdf->loadHtml($html);
                    
                    $dompdf->setPaper('A4', 'portrait');

                    // Rendu et sortie du PDF
                    $dompdf->render();
                    $output = $dompdf->output();
                    
                    file_put_contents(public_path('ticketPdf/ticket'.Auth::user()->id.'_'.$ticket->id.'_'.trim($data->type_ticket->evenement->nom_evenement).'.pdf'), $output);         
                    
                    $filePath=public_path('ticketPdf/ticket'.Auth::user()->id.'_'.$ticket->id.'_'.trim($data->type_ticket->evenement->nom_evenement).'.pdf');

                    $attach[]=$filePath;
                }else{
                    $user_id=Auth::user()->id;
                    $type_ticket_id=$type_ticket->id;
                    $token=hash('sha256', $user_id . $type_ticket_id . config('app.key'));
                    $link =route('eventRedirecting',['type_ticket'=>$type_ticket_id,'token'=>$token]);
                    $ticket->LienUnique=$link;
                    $ticket->save();
                    $data=$ticket;
                    $attach[]=$link;
                }
                
            }
            $mailData=[
                'subject'=>'Tickets pour '. $data->type_ticket->evenement->nom_evenement,
            ];
            if($data->type_ticket->evenement->type_lieu->nom_type=="physique"){
               $mailData['body']='Bonjour '.Auth::user()->name.' Veuillez trouver ci-joint les tickets pour '.$data->type_ticket->evenement->nom_evenement;
               Mail::to(Auth::user()->email)
               ->send(new InfoUser($mailData,$attach)); 
            }elseif($data->type_ticket->evenement->type_lieu->nom_type=="En ligne"){
                $mailData['body'] = "Bonjour". Auth::user()->name .",\n Veuillez trouver ci-dessous les liens pour ". $data->type_ticket->evenement->nom_evenement .":\n\n";

                // Ajouter tous les liens dans le corps du message
                foreach ($attach as $link) {
                    $mailData['body'] .=  $link ;
                }
                $attach=[];

                // Envoi du mail avec tous les liens dans un unique message
                Mail::to(Auth::user()->email)
                    ->send(new InfoUser($mailData,$attach)); 
             }
          
           
            return redirect()->route('ticket.index');
        }
        else{
            return redirect()->route('login');
        }

    }



    /**
     * Display the specified resource.
     */
    public function show(ticket $ticket)
    {
        $data = Ticket::find($ticket->id);
        return view('admin.ticket.generatedTicket',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateticketRequest $request, ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ticket $ticket)
    {

    }

    public function verifiedTransaction( Request $request){ 
        $type_ticket=type_ticket::find($request->type_ticket_id);
        if($type_ticket->place_dispo > 0 || $type_ticket->place_dispo <$request->nbr){
            if ($type_ticket->format=='Ticket') {
                if ($request->transaction_id) {
                    $transaction_id=$request->transaction_id;
                    Fedapay::setApiKey('sk_sandbox_HrsJbuyRPcQImLZ521a9uj1d');
                    Fedapay::setEnvironment('sandbox');
                    $transaction = Transaction::retrieve($transaction_id);
                    if ($transaction) {
                        if ($transaction->status=='approved') {
                            $nbreTicket=$request->nbr;
                            return response()->json([
                                'message'=>'la transaction est réussie',
                                'transaction_id'=>$transaction_id,
                                'nbreTicket'=>$nbreTicket,
                                'type_ticket_id'=>$type_ticket->id
                            ]);
                        }else{
                            return redirect()->route('ticket.create')->with('error','la transaction n\'a pas été éffectué');
                        }
                    }else {
                        return redirect()->route('ticket.create')->with('error','la transaction n\'existe pas');
                    }

                }
            }else {
            
                $nbreTicket=$request->nbr;
                $transaction_id=uniqid();
                return response()->json([
                    'message'=>'la transaction est réussie',
                    'transaction_id'=>$transaction_id,
                    'nbreTicket'=>$nbreTicket,
                    'type_ticket_id'=>$type_ticket->id
                ]);
            }
        }else{
            return response()->json([
                'error'=>'le ticket est sold out',
            ]);
        }
    }

    public function SendTicket(Request $request ){
        $validatedData=$request->validate([
            'nbr'=>'required',
            'type_ticket_id'=>'required',
        ]);
        $transaction_id=$request->transaction_id;
        $nbr=$request->nbr;
        $type_ticket_id=$request->type_ticket_id;
        return view('admin.ticket.sendTiket',compact('transaction_id','type_ticket_id','nbr'));
    }

    public function TicketSelected(StoreticketRequest $request){
        session(['ticket_id'=>$request->ticket]);
        return redirect()->route('ticket.create');
    }

    public function nombreTicket(StoreticketRequest $request){
        session(['nombreTicket'=>$request->nombreTicket]);
        $user=Auth::user();
        return response()->json([
            'nombreTicket'=>$request->nombreTicket,
            'name'=>$user->name,
            'email'=>$user->email,
            'numero'=>$user->num_user,
        ]);
    }

    public function scanTicket(){
        return view('admin.ticket.scanTicket');
    }

    public function verifierTicket(Request $request){
       
       
        $signature=$request->signature;
        $ticket=ticket::where('signature',$signature)->first();
    
        if(session('evenement_id')){
            $validRoute=route('validTicket');
            $invalidRoute=route('invalidTicket');
            $verifiedRoute=route('verifiedTicket');
            $eventToControl=evenement::find(session('evenement_id'));
        }else{
            $validRoute=route('validTicketControleur');
            $invalidRoute=route('invalidTicketControleur');
            $verifiedRoute=route('verifiedTicketControleur');
            $user=auth()->user();
            $controleur=$user->Controleur;
            $eventToControl=$controleur->evenements()->wherePivot('statut','activé')->first();
        }
        if (!$ticket) {
            if(session('evenement_id')){
                tickets_verifications::create([
                    "statut"=>"ticket invalide",
                    "ticket_id"=>null,
                    "nom_controleur"=>$eventToControl->profil_promoteur->pseudo,
                    "num_controleur"=>$eventToControl->profil_promoteur->user->num_user,
                    "mail_controleur"=>$eventToControl->profil_promoteur->user->email,
                    "profil_promoteur_id"=>$eventToControl->profil_promoteur->id,
                    "evenement_id"=>$eventToControl->id
                ]);
            }else{
                tickets_verifications::create([
                    "statut"=>"ticket invalide",
                    "ticket_id"=>null,
                    "nom_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->name,
                    "num_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->telephone,
                    "mail_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->email,
                    "controleur_id"=>$controleur->id,
                    "evenement_id"=>$eventToControl->pivot->evenement_id
                ]);
            }
            
            return response()->json([
                "qrcodevalidity"=>"invalid ticket",
                "redirectTo"=>$invalidRoute
            ]);
        }
        $data=json_encode([
            "ticket_id"=> $ticket->id,
            "user_id"=> $ticket->user_id, 
            "evenement_id"=>$ticket->type_ticket->evenement_id,
        ]);
        $keyRepoName=hash('sha256',$eventToControl->id.'_'.$eventToControl->profil_promoteur->id.'_130125');
        $KeyDir=storage_path("app/keys/$keyRepoName/public_key.pem");
        $publicKey=RSA::loadPublicKey(file_get_contents($KeyDir));
        $signature=base64_decode($signature);
        if ($publicKey->verify($data,$signature)) {
            if($ticket->statut=="vérifié"){
                if(session('evenement_id')){
                     tickets_verifications::create([
                        "statut"=>"ticket vérifié",
                        "ticket_id"=>$ticket->id,
                        "nom_controleur"=>$eventToControl->profil_promoteur->pseudo,
                        "num_controleur"=>$eventToControl->profil_promoteur->user->num_user,
                        "mail_controleur"=>$eventToControl->profil_promoteur->user->email,
                        "profil_promoteur_id"=>$eventToControl->profil_promoteur->id,
                        "evenement_id"=>$eventToControl->id
                    ]);
                }else{
                    tickets_verifications::create([
                        "statut"=>"ticket vérifié",
                        "ticket_id"=>$ticket->id,
                        "nom_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->name,
                        "num_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->telephone,
                        "mail_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->email,
                        "controleur_id"=>$controleur->id,
                        "evenement_id"=>$eventToControl->pivot->evenement_id
                    ]);
                }
                return response()->json([
                    "qrcodevalidity"=>"verifiedTicket",
                    "redirectTo"=>$verifiedRoute
                ]);
            }
            if(session('evenement_id')){
                tickets_verifications::create([
                    "statut"=>"ticket valide",
                    "ticket_id"=>$ticket->id,
                    "nom_controleur"=>$eventToControl->profil_promoteur->pseudo,
                    "num_controleur"=>$eventToControl->profil_promoteur->user->num_user,
                    "mail_controleur"=>$eventToControl->profil_promoteur->user->email,
                    "profil_promoteur_id"=>$eventToControl->profil_promoteur->id,
                    "evenement_id"=>$eventToControl->id
                ]);
            }else{
                tickets_verifications::create([
                    "statut"=>"ticket valide",
                    "ticket_id"=>$ticket->id,
                    "nom_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->name,
                    "num_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->telephone,
                    "mail_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->email,
                    "controleur_id"=>$controleur->id,
                    "evenement_id"=>$eventToControl->pivot->evenement_id
                ]);
            }
            $ticket->statut="vérifié";
            $ticket->save();
            return response()->json([
                "qrcodevalidity"=>"valid",
                "redirectTo"=>$validRoute
            ]);
        }else {
            if(session('evenement_id')){
                tickets_verifications::create([
                    "statut"=>"ticket invalide",
                    "ticket_id"=>$ticket->id,
                    "nom_controleur"=>$eventToControl->profil_promoteur->pseudo,
                    "num_controleur"=>$eventToControl->profil_promoteur->user->num_user,
                    "mail_controleur"=>$eventToControl->profil_promoteur->user->email,
                    "profil_promoteur_id"=>$eventToControl->profil_promoteur->id,
                    "evenement_id"=>$eventToControl->id
                ]);
            }else{

                tickets_verifications::create([
                    "statut"=>"ticket invalide",
                    "ticket_id"=>$ticket->id,
                    "nom_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->name,
                    "num_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->telephone,
                    "mail_controleur"=>$controleur->evenements()->wherePivot("evenement_id",$eventToControl->pivot->evenement_id)->first()->pivot->email,
                    "controleur_id"=>$controleur->id,
                    "evenement_id"=>$eventToControl->pivot->evenement_id

                ]);
            }
              return response()->json([
                "qrcodevalidity"=>"invalid ticket",
                "redirectTo"=>$invalidRoute
            ]);
        }
      
    }
    public function validTicket(){
        return view('admin.ticket.validTicket');
    }
    public function verifiedTicket(){
        return view('admin.ticket.verifiedTicket');
    }
    public function invalidTicket(){
        return view('admin.ticket.invalidTicket');
    }

    public function eventToVerify(){
        $evenements=Auth()->user()->Profil_promoteur->evenements;
        return view('admin.ticket.eventToVerify', compact('evenements'));
    }

    public function eventSending(Request $request){
       $evenement_id=$request->evenement_id;
       session(['evenement_id'=>$evenement_id]);
       return redirect()->route('scanTicket');
    }

    public function downloadTicket(Ticket $ticket){
        $data = Ticket::find($ticket->id);
          // Génération du contenu HTML
          $html = view('admin.ticket.generatedTicket',compact('data'));

          // Initialisation de Dompdf (via le fournisseur de service)
          $dompdf = app(Dompdf::class);

          // Chargement du contenu HTML
          $dompdf->loadHtml($html);
          
          $dompdf->setPaper('A4', 'portrait');

          // Rendu et sortie du PDF
          $dompdf->render();

          return $dompdf->stream('document.pdf', ['Attachment' => 1]); 
    }
    
    public function GetAmount(Request $request){
        $Amount=$request->montant;
        $user=Auth::user();
        $userInfo=[
            "firstname" => explode(" ", $user->name)[1],
            "lastname" => explode(" ", $user->name)[0],
            "email" => $user->email,
            "phone_number" => [
                "number" => $user->num_user,
                "country" => 'bj' // 'bj' Benin code
                ]
            ];
        session(['Amount'=>$Amount,'userInfo'=>$userInfo]);
        return redirect()->route('UserInfo');
    }

    public function UserInfo(){
        $userInfo=session('userInfo');
        return view('admin.ticket.userInfo',compact('userInfo'));
    }

    public function GetUserInfo(Request $request){
        $validateData=$request->validate([
            "firstname"=>"required",
            "lastname"=>"required",
            "email"=>"required",
            "number"=>"required",
        ]);
    
        /* Remplacez YOUR_SECRETE_API_KEY par votre clé API secrète */
        \FedaPay\FedaPay::setApiKey("sk_sandbox_HrsJbuyRPcQImLZ521a9uj1d");
        /* Indiquez si vous souhaitez exécuter votre requête en mode test ou en live */
        \FedaPay\FedaPay::setEnvironment('sandbox'); //or setEnvironment('live');
        /* Créer un client */
        $customer= \FedaPay\Customer::create(array(
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "email" => $request->email,
                "phone_number" => [
                    "number" => $request->number,
                    "country" => 'bj' // 'bj' Benin code
                ]
            ));

        \FedaPay\Fedapay::setApiKey('sk_sandbox_HrsJbuyRPcQImLZ521a9uj1d');
        \FedaPay\Fedapay::setEnvironment('sandbox');
        $transaction = \FedaPay\Transaction::create([
        'description' => 'Payment for order #1234',
        'amount' => 1000,
        'currency' => ['iso' => 'XOF'],
        'callback_url' => route('ticket.index'),
        'mode' => 'mtn_open',
        'customer' => ['id' => $customer->id]
        ]);
        $token = $transaction->generateToken();
        return redirect($token->url);
    }

    public function AllParticipant(evenement $evenement){
        $evenement_id=$evenement->id;
        $participants=User::whereHas('tickets',function($query) use ($evenement_id){
            $query->whereHas('type_ticket',function($query) use ($evenement_id){
                $query->where('evenement_id', $evenement_id);
            });
        })->get();
      
        return view('admin.ticket.AllParticipant',compact('participants','evenement_id'));
    }

    public function CreateInvitation(type_ticket $type_ticket){
        return view('admin.ticket.invitation',compact('type_ticket'));
    }
}
