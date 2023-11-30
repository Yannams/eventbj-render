<?php

namespace App\Http\Controllers;

use App\Models\chronogramme;
use App\Models\evenement;
use App\Http\Requests\StoreevenementRequest;
use App\Http\Requests\UpdateevenementRequest;
use App\Models\type_evenement;
use App\Models\type_ticket;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;

class EvenementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    public function index()
    {
        $evenement = evenement::where('isOnline', true)
                    //->where('type_evenement_id', $type)
                    ->get();
        $type_evenement=type_evenement::all();
        //dd($evenement);
        return view('admin.evenement.index', compact('evenement', 'type_evenement'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $typeLieuId = $request->query('type_lieu_event');
        $type_evenement=type_evenement::all();
        return view('admin.evenement.create', compact('typeLieuId','type_evenement'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreevenementRequest $request)
    {
        //$this->authorize('create', evenement::class);
        $userId = auth()->user()->id;
        $evenement=new evenement;
        $evenement->nom_evenement=$request->nom_evenement;
        $evenement->localisation=$request->localisation;
        $evenement->type_evenement_id=$request->type_evenement_id;
        $evenement->isOnline=false;
        //$evenement->date_heure_debut=$request->date_heure_debut;
        //$evenement->date_heure_fin=$request->date_heure_fin;
        $evenement->description=$request->description;
        //$imagePath = $request->file('cover_event')->store('image_evenement');
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
        $evenement->user_id=$userId;
        $evenement->save();
     

        $typelieu=$request->input('type_lieu_selected');
        $evenement->type_lieus()->attach($typelieu);
        $evenement_id=$evenement->id;
        session(['evenement_id'=>$evenement_id]);
        
        return redirect()->route('chronogramme.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(evenement $evenement)
    {
        $evenement=evenement::find($evenement->id);
        $date= new DateTime($evenement->date_heure_debut);
        $user_id=$evenement->user_id;
        $organisateur=User::find($user_id);
        $chronogramme=chronogramme::where('evenement_id',$evenement->id)->get();
        $ticket= type_ticket::where('evenement_id',$evenement->id)->get();
    
        return view('admin.evenement.show', compact('evenement', 'date','organisateur','chronogramme', 'ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(evenement $evenement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateevenementRequest $request, evenement $evenement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(evenement $evenement)
    {
        //
    }

    public function MyEvents(){
        $userId = auth()->user()->id;
        $user = User::with('evenements')->find($userId);
        if ($user) {
            $evenement = $user->evenements;
            return view("admin.evenement.mesEvenements", compact("evenement"));
        } else {
            // Gérez le cas où l'événement n'a pas été trouvé
           // return view("admin.type_ticket.index", compact("evenement"));
        }
        return view("admin.evenement.mesEvenements");
    }
    
    public function OnlineEvents(evenement $evenement){
        $evenement=evenement::find( $evenement->id );
        $evenement->isOnline=true;
        $evenement->save();
        return redirect()->route('MesEvenements');

    }

    public function filteredByTypeEvents($type){
        if($type==1){
            $evenement = evenement::where('isOnline', true)->get();
        } else {
            $evenement = evenement::where('isOnline', true)
            ->where('type_evenement_id', $type)
            ->get();
        }
        
        $type_evenement=type_evenement::all();
        return view('admin.evenement.index', compact('evenement', 'type_evenement'));

    }
}

