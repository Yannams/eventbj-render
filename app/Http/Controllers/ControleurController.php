<?php

namespace App\Http\Controllers;

use App\Mail\InfoUser;
use App\Models\Controleur;
use App\Http\Requests\StoreControleurRequest;
use App\Http\Requests\UpdateControleurRequest;
use App\Models\evenement;
use App\Models\Profil_promoteur;
use App\Models\tickets_verifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
class ControleurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=Auth::user();
        $profil_promoteur_id=$user->Profil_promoteur->id;
        $controleurs=Controleur::where('profil_promoteur_id',$profil_promoteur_id)->get();

        return view('admin.controleur.index',compact('controleurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreControleurRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Controleur $controleur)
    {
        return view('admin.controleur.show',compact('controleur'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Controleur $controleur)
    {   
        $evenements=$controleur->profil_promoteur->evenements->where('date_heure_fin','>=',now());
        return view('admin.controleur.edit',compact('controleur','evenements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateControleurRequest $request, Controleur $controleur)
    {
        $validatedData=$request->validate([
            'name'=>'required',
            'evenement_id'=>'required',
        ]);
        if($controleur->evenements()->wherePivot('evenement_id',$request->evenement_id)->exists()){
            $controleur_evenement=$controleur->evenements()->wherePivot('evenement_id',$request->evenement_id)->first();
            return redirect()->route('controleur.show',$controleur)->with("error","le compte $controleur->ControleurId a déjà été attribué à {$controleur_evenement->pivot->name} pour contrôler $controleur_evenement->nom_evenement ");
        }
        $controleur->evenements()->attach($request->evenement_id,['name'=>$request->name,'telephone'=>$request->telephone,'email'=>$request->email,'created_at'=>now(),'updated_at'=>now()]);
        $user_id=$controleur->user_id;
        $user=User::find($user_id);
        $user->password=Hash::make($request->password);
        $user->update();
        return redirect()->route('controleur.show',$controleur )->with('message'," Le controle a été créé");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Controleur $controleur)
    {
        
    }

    public function choiceProcess(){
        return view('admin.controleur.choiceProcess');
    }

    public function controleurAccess(){
        $user_id=Auth::user()->id;
        $controleur=User::find($user_id)->Controleur;
        $sessions= DB::table('sessions')->where('user_id',$user_id);
        $controleurEvenementActif= $controleur->evenements()->wherePivot('statut','activé');
        if($controleurEvenementActif->exists()  ){
            if ($sessions->count()>1) {
                auth()->logout();
                $controleur->evenements()->updateExistingPivot($controleurEvenementActif->first()->id,["statut"=>"désactivé"]);
                Log::error("Tentative de connexion de connexion de plusieurs appareil grace au {$controleur->ControleurId}");
                return redirect()->route('login')->with('error',"Tentative de connexion de connexion de plusieurs appareils. Veuillez contacter le promoteur pour réactiver votre compte");                   
            }
            // if ($controleurEvenementActif->first()->date_heure_debut > now()) {
            //     auth()->logout();
            //     Log::error("connexion non autorisée du controleur $controleur->ControleurId avant le début de l'évènement");
            //     return redirect()->route('login')->with('error',"la connexion n'est pas autorisée. L'évènement n'a pas commencé");   
            // }
            if ($controleurEvenementActif->first()->date_heure_fin < now()) {
                auth()->logout();
                Log::error("connexion non autorisée du controleur $controleur->ControleurId après la date de fin : ".now());
                return redirect()->route('login')->with('error',"la connexion n'est pas autorisée.L'évènement est terminé");   
            }
            return view('admin.controleur.scanTicket');
        }else{
            auth()->logout();
            Log::error("connexion non autorisée du controleur $controleur->ControleurId");
           return redirect()->route('login')->with('error',"la connexion n'est pas activé par le promoteur. Veuillez contacter le promoteur  pour réactivation"); 
        }
       
    }

    public function validTicket(){
        return view('admin.controleur.validTicket');
    }
    public function verifiedTicket(){
        return view('admin.controleur.verifiedTicket');
    }
    public function invalidTicket(){
        return view('admin.controleur.invalidTicket');
    }

    public function editControl(evenement $evenement, Controleur $controleur){
        $evenement_controleur=$evenement->controleurs()->wherePivot('controleur_id',$controleur->id)->first()->pivot;
        $evenements=$controleur->profil_promoteur->evenements->where('date_heure_fin','>=',now());
        return view('admin.controleur.editControl',compact('evenement_controleur','controleur','evenements'));
    }

    public function updateControl(evenement $evenement, Controleur $controleur, Request $request){
        $rules= [
            'name'=>'required',
            'evenement_id'=>'required',
        ];
        $validatedData=$request->validate($rules);
        if ($request->email) {
            $validatedData['email']=$request->email;
        }
        if($request->telephone){
            $validatedData['telephone']=$request->telephone;   
        }
        $controleur->evenements()->updateExistingPivot($evenement->id, $validatedData); 
        return redirect()->route('controleur.show',$controleur);
        
    }

    public function activerControl(evenement $evenement,Controleur $controleur){
        if($controleur->evenements()->wherePivot('statut','activé')->exists()){
            return redirect()->route('controleur.show',$controleur)->with('error','vous devez désactiver le control actif');
        }
        return view('admin.controleur.activerControl',compact('controleur','evenement'));
    }

    public function executeActivation(Request $request){
        $validatedData=$request->validate([
            'password'=>['required', 'string', 'confirmed',Password::min(8)->letters()->numbers()],
            'controleur_id'=>"required",
            'evenement_id'=>"required",
        ]);
        $controleur=Controleur::find($request->controleur_id);
        $user_id=$controleur->user_id;
        $user=User::find($user_id);
        $user->password=Hash::make($request->password);
        $user->update();
        $controleur->evenements()->updateExistingPivot($request->evenement_id,['statut'=>'activé']);
        
        $mailData=[
            'subject' => 'Activation de votre compte controleur',
              'body' => "Bonjour,
              Le promoteur {$controleur->profil_promoteur->pseudo} vous a attribué un compte controleur pour les tickets de l'évenement
              {$controleur->evenements()->wherePivot('evenement_id',$request->evenement_id)->first()->nom_evenement}\n 
              Voici vos identifiant \n
              Identifiant: {$controleur->ControleurId}
              Mot de passe : {$request->password}"
          ];
          $attach=[];          
        Mail::to($controleur->evenements()->wherePivot('evenement_id',$request->evenement_id)->first()->pivot->email)
        ->send(new InfoUser($mailData,$attach));
        return redirect()->route('controleur.show',$controleur)->with('message','le controle est activé');
    }

    public function executeDesactivation(evenement $evenement,Controleur $controleur){
        $controleur->evenements()->updateExistingPivot($evenement->id, ['statut'=>'désactivé']);
        $userId=$controleur->user_id;
        DB::table('sessions')->where('user_id', $userId)->delete();
        return redirect()->route('controleur.show',$controleur)->with('message','le controle est désactivé');

    }

    public function ControlHistoric(evenement $evenement,Controleur $controleur){
        $ticketsControleur=tickets_verifications::where("controleur_id",$controleur->id)->where("evenement_id",$evenement->id)->get();
        $evenement_id=$evenement->id;
        return view('admin.controleur.controlHistoric',compact('ticketsControleur','evenement_id'));
    }

    
}
