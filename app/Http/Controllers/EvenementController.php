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
use DateTime;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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
        return redirect()->route('type ticket.create')->with('message', 'evenement créé');    

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
    
    public function OnlineEvents(evenement $evenement){
        $evenement=evenement::find( $evenement->id );
        $evenement->isOnline=true;
        $evenement->save();
        return redirect()->route('MesEvenements')->with('message', 'Evènement mis en ligne');
       
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
        return view('admin.evenement.create_event');
    }

}


