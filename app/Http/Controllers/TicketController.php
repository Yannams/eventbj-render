<?php

namespace App\Http\Controllers;

use App\Mail\InfoUser;
use App\Models\ticket;
use App\Http\Requests\StoreticketRequest;
use App\Http\Requests\UpdateticketRequest;
use App\Models\evenement;
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
// use Fedapay\Fedapay;
// use Fedapay\Customer;

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
            $nombreTicket=session('nombreTicket');
            $type_ticket=type_ticket::find($request->id_type_ticket);
            $cover_ticket=$type_ticket->image_ticket;
            $attach=array();
            
       
            for($i=0; $i<$nombreTicket; $i++){
                $user=auth()->user()->id;
                $userdata=User::find($user);

                $ticket = new Ticket;
                $ticket->transaction_id=$request->transaction_id;
                $ticket->type_ticket_id=$request->id_type_ticket;
                $ticket->statut="activé";
                $ticket->user_id=$user;
                $ticket->save();           
               
                if($type_ticket->evenement->type_lieu->nom_type =="physique"){
                    $evenement=$type_ticket->evenement;
                    $evenement_id=$evenement->id;
                    $promoteur_id=$evenement->profil_promoteur->id;
                    $keyRepoName=hash('sha256',$evenement->id.'_'.$evenement->profil_promoteur->id.'_130125');
                    
                    $codeQRContent = json_encode([
                        "id_ticket"=>$ticket->id, 
                        "transaction_id"=>$ticket->transaction_id, 
                        "user"=> $user, 
                        "nom_user"=> $userdata->name, 
                        "statut"=> $ticket->statut,
                        "id_evenement"=>$ticket->type_ticket->evenement->id,
                        "nom_evenement"=>$ticket->type_ticket->evenement->nom_evenement,
                        "date_heure_debut"=>$ticket->type_ticket->evenement->date_heure_debut,
                        "date_heure_fin"=>$ticket->type_ticket->evenement->date_heure_fin,
                        "signature"=>file_get_contents(storage_path("app/keys/$keyRepoName/private_key.pem"))
                    ]);
                    
                    $folderPath = public_path('code_QR');
                    if (!file_exists($folderPath)) {
                        mkdir($folderPath, 0777, true);
                    }
                    $fileName = uniqid() . '.svg';
                    $filePath = $folderPath . '\\' . $fileName;
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

    public function verifiedTransaction($type_ticket_id){ 
        if(isset($_GET['transaction_id']))  {    
            $type_ticket=type_ticket::find($type_ticket_id);
            $transaction_id=$_GET['transaction_id'];
            $nbreTicket=$_GET['nbr'];
            session(['nombreTicket'=>$nbreTicket]);
            return view('admin.ticket.sendTiket',compact('transaction_id','type_ticket'));
        }
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
       
        $id_ticket=$request->id_ticket;
        $id_evenement=session('evenement_id');
        $ticket=ticket::find($id_ticket);
        $evenement=evenement::find($id_evenement);
        // dd($request,  $ticket->transaction_id, $ticket->statut, $evenement->nom_evenement,$request->date_heure_debut, $evenement->date_heure_debut, $request->date_heu:re_fin, $evenement->date_heure_fin);
        if ($request->transaction_id==$ticket->transaction_id && $request->statut=="activé" && $request->statut==$ticket->statut && $request->nom_evenement==$evenement->nom_evenement && date('d/m/Y h:i:s', strtotime($request->date_heure_debut)) == date('d/m/Y h:i:s', strtotime($evenement->date_heure_debut)) && date('d/m/Y h:i:s', strtotime($request->date_heure_fin)) == date('d/m/Y h:i:s', strtotime($evenement->date_heure_fin))) {
            $ticket->statut="vérifié";
            $ticket->save();
           return response()->json([
                "qrcodevalidity"=>"valid",
                "redirectTo"=>route('validTicket')
           ]);
        }elseif($request->statut=="vérifié"){
            return response()->json([
                "qrcodevalidity"=>"verifiedTicket",
                "redirectTo"=>route('verifiedTicket')
           ]);
        }else{
            return response()->json([
                "qrcodevalidity"=>"invalid ticket",
                "redirectTo"=>route('invalidTicket')
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
}
