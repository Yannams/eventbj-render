<?php

namespace App\Http\Controllers;

use App\Models\ticket;
use App\Http\Requests\StoreticketRequest;
use App\Http\Requests\UpdateticketRequest;
use App\Models\type_ticket;
use App\Models\User;
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
            for($i=0; $i<$nombreTicket; $i++){
                $user=auth()->user()->id;
                $userdata=User::find($user);
                $ticket = new Ticket();
                $ticket->transaction_id=$request->transaction_id;
                $ticket->type_ticket_id=$request->id_type_ticket;
                $ticket->statut="acheté";
                $ticket->save();           
                $ticket->users()->attach($user);
                $codeQRContent = "$ticket->id $ticket->transaction_id $user $userdata->name $ticket->statut";
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
                $manager = ImageManager::gd();
                $image = $manager->read($cover_ticket);
                dd($QrCodePath);
                // paste another image
                $image->place($QrCodePath);

                // create a new resized watermark instance and insert at bottom-right 
                // corner with 10px offset and an opacity of 25%
                $image->place(
                    'images/watermark.png',
                    'bottom-right', 
                    10, 
                    10,
                    25
                );
               
             
                             
            }
           
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
}
