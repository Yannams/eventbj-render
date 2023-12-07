<?php

namespace App\Http\Controllers;

use App\Models\ticket;
use App\Http\Requests\StoreticketRequest;
use App\Http\Requests\UpdateticketRequest;
use App\Models\type_ticket;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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
        $type_ticket_id=$_GET['ticket'];
        $type_ticket = type_ticket::find($type_ticket_id);
        return view('admin.ticket.create',compact('type_ticket'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( StoreticketRequest $request)
    {
        if(auth()->check()){
            $user=auth()->user()->id;
            $destinationPath=public_path('image_ticket_acheté');
            QrCode::generate(, '../public/qrcodes/qrcode.svg');
            $ticket = new Ticket();
            $ticket->transaction_id=$request->transaction_id;
            $ticket->type_ticket_id=$request->id_type_ticket;
            
            $ticket->save();
            $ticket->users()->attach($user);
        }else{
            
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
}
