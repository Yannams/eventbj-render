<?php

namespace App\Http\Controllers;

use App\Models\chronogramme;
use App\Http\Requests\StorechronogrammeRequest;
use App\Http\Requests\UpdatechronogrammeRequest;
use App\Models\evenement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ChronogrammeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.programmation.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {    $data = $request->validate([
            'event' => 'required|integer|exists:evenements,id',
        ]);
        $chronogrammes=chronogramme::where('evenement_id',$data['event'])->get();
        $evenement=evenement::find($data['event']);
        // $this->authorize('create',[chronogramme::class,$evenement]);
        return view('admin.programmation.create',compact('evenement','chronogrammes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorechronogrammeRequest $request)
    {
      
        $data=$request->validate([
            'evenement_id'=>'required|integer|exists:evenements,id',
            'heure_debut'=>'required|date_format:H:i|before:heure_fin',
            'heure_fin'=>'required|date_format:H:i|after:heure_debut',
            'nom_activite'=>"required|string",
            'date_activite'=>['required', 'date_format:Y-m-d']
        ]);
         

        $evenement=evenement::find($data['evenement_id']);
        $this->authorize('store',[chronogramme::class,$evenement]);
        $date_activite = Carbon::parse( $data['date_activite'])->startOfDay();
        $date_heure_debut = Carbon::parse($evenement->date_heure_debut)->startOfDay(); 
        $date_heure_fin = Carbon::parse($evenement->date_heure_fin)->startOfDay(); 
       
        Validator::make($request->all(), [
            'date_activite' => [
                function ($attribute, $value, $fail) use ($evenement,$date_activite,$date_heure_fin) {
                    if ($date_activite->gt($date_heure_fin)) {
                        $fail("La date doit être antérieure ou égale à la date de fin de l'événement ({$date_heure_fin}).");
                    }
                },
                function ($attribute, $value, $fail) use ($evenement,$date_activite,$date_heure_debut) {
                    if ($date_activite->lt($date_heure_debut)) {
                        $fail("La date doit être postérieure ou égale à la date de début de l'événement ({$date_heure_debut}).");
                    }
                }
            ],
        ])->validate();
       $chronogramme=chronogramme::create($data);

       return response()->json([
        'success'=>true,
        'chronogramme_id'=>$chronogramme->id,
        'evenement_id'=>$chronogramme->evenement_id,
        'heure_debut'=>$chronogramme->heure_debut,
        'heure_fin'=>$chronogramme->heure_fin,
        'nom_activite'=>$chronogramme->nom_activite,
        'date_activite'=>$chronogramme->date_activite,
       ]);
    }
    
    


    /**
     * Display the specified resource.
     */
    public function show(chronogramme $chronogramme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(chronogramme $chronogramme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatechronogrammeRequest $request, chronogramme $chronogramme)
    {
       $chronogramme = chronogramme::find($chronogramme->id);
       $chronogramme->heure_debut=$request->heure_debut;
       $chronogramme->heure_fin=$request->heure_fin;
       $chronogramme->nom_activite=$request->nom_activite;
       $chronogramme->save();
       return response()->json([
        'success'=>true,
        'chronogramme_id'=>$chronogramme->id,
        'evenement_id'=>$chronogramme->evenement_id,
        'heure_debut'=>date('H:i',strtotime($chronogramme->heure_debut)),
        'heure_fin'=>date('H:i',strtotime($chronogramme->heure_fin)),
        'nom_activite'=>$chronogramme->nom_activite,
        'date_activite'=>$chronogramme->date_activite,
       ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(chronogramme $chronogramme)
    {
        //
    }

    public function edit_chronogramme(evenement $evenement ){
        $evenement_id=$evenement->id;
        $chronogramme=chronogramme::where('evenement_id',$evenement_id)->get();
        
        return view('admin.programmation.edit_programmation',compact('evenement','evenement_id','chronogramme'));
    }


}
