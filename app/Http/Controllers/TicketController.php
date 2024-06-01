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
use Illuminate\Support\Facades\Mail;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use PhpParser\Node\Stmt\Foreach_;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $ticket=ticket::all();
      
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
                $ticket = new Ticket();
                $ticket->transaction_id=$request->transaction_id;
                $ticket->type_ticket_id=$request->id_type_ticket;
                $ticket->statut="activé";
                $ticket->save();           
                $ticket->users()->attach($user);
                
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
                
            }
            $mailData=[
                'subject'=>'Tickets pour '. $data->type_ticket->evenement->nom_evenement,
                'body'=>'Bonjour '.Auth::user()->name.' Veuillez trouver ci-joint les tickets pour '.$data->type_ticket->evenement->nom_evenement,
            ];

            Mail::to(Auth::user()->email)
                ->send(new InfoUser($mailData,$attach)); 
           
            return redirect()->route('ticket.index');
        }
            else
        {
            return redirect()->route('login');
        }

    }



    /**
     * Display the specified resource.
     */
    public function show(ticket $ticket)
    {
        //
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
            return view('admin.ticket.sendTiket',compact('transaction_id','type_ticket'));
        }
    }

    public function TicketSelected(StoreticketRequest $request){
        session(['ticket_id'=>$request->ticket]);
        return redirect()->route('ticket.create');
    }

    public function nombreTicket(StoreticketRequest $request){
        session(['nombreTicket'=>$request->nombreTicket]);
    }

    public function scanTicket(){
        return view('admin.ticket.scanTicket');
    }

    public function verifierTicket(Request $request){
       
        $id_ticket=$request->id_ticket;
        $id_evenement=$request->id_evenement;
        $ticket=ticket::find($id_ticket);
        $evenement=evenement::find($id_evenement);
        // dd($request,  $ticket->transaction_id, $ticket->statut, $evenement->nom_evenement,$request->date_heure_debut, $evenement->date_heure_debut, $request->date_heu:re_fin, $evenement->date_heure_fin);
        if ($request->transaction_id==$ticket->transaction_id && $request->statut=="activé" && $request->statut==$ticket->statut && $request->nom_evenement==$evenement->nom_evenement && date('d/m/Y h:i:s', strtotime($request->date_heure_debut)) == date('d/m/Y h:i:s', strtotime($evenement->date_heure_debut)) && date('d/m/Y h:i:s', strtotime($request->date_heure_fin)) == date('d/m/Y h:i:s', strtotime($evenement->date_heure_fin))) {
            $ticket->statut="désactivé";
            $ticket->save();
           return response()->json([
                "qrcodevalidity"=>"valid",
                "redirectTo"=>route('validTicket')
           ]);
        }elseif($request->statut=="désactivé"){
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
}
