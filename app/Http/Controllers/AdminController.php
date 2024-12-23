<?php

namespace App\Http\Controllers;

use App\Models\chronogramme;
use App\Models\evenement;
use App\Models\Intervenant;
use App\Models\Profil_promoteur;
use App\Models\ticket;
use App\Models\type_ticket;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class AdminController extends Controller
{
    public function AllEvents(){
      $evenements=evenement::all();
      return view('administrative.evenement.index',compact('evenements'));  
    }

    public function administrative_activation(Request $request){
      $evenement_id= $request->evenement_id;
      $evenement=evenement::find( $evenement_id );
      
      /*
      *Je vérifie d'abord que tous les tickets d'un évènements ont une date de lancement et un date de fermeture
      *Si la date de lancement est nulles et que la méthode est ActivationEvènement je met la date du jour
      *Si les deux dates sont nulle le rediriger vers un endroit ou il pourra changer la date
      *Si rien n'est null mettre l'evènement en ligne 
       */
      
      if($evenement->administrative_status==true){

          $evenement->administrative_status=false;
          $evenement->recommanded=false;
          $evenement->isOnline=false;
          $evenement->save();
          return response()->json([
              "success"=>true,
              "status"=>false,
              "message"=>"evenement désactivé adminstrativement"
          ]);
        }
      else
      {
          $evenement->administrative_status=true;
          $evenement->save();
          return response()->json([
              "success"=>true,
              "status"=>true,
              "message"=>"evenement activé adminstrativement"
          ]);
      }
     
  }

  public function Recommand_Event(Request $request){
    $evenement_id= $request->evenement_id;
    $evenement=evenement::find( $evenement_id );
    
    /*
    *Je vérifie d'abord que tous les tickets d'un évènements ont une date de lancement et un date de fermeture
    *Si la date de lancement est nulles et que la méthode est ActivationEvènement je met la date du jour
    *Si les deux dates sont nulle le rediriger vers un endroit ou il pourra changer la date
    *Si rien n'est null mettre l'evènement en ligne 
     */
    
    if($evenement->recommanded==true){
      $evenement->recommanded=false;
        $evenement->save();
       
        return response()->json([
            "success"=>true,
            "status"=>false,
            "message"=>"retiré des recommandation"
        ]);
      }
    else
    {
      
      if($evenement->isOnline==false){
          return response()->json([
            "success"=>false,
            "status"=>false,
            "message"=>"evenement non publié par le promoteur"
        ]);
      }
      else{
        if($evenement->cover_recommanded==""){
          $cover_event=$evenement->cover_event;

          $manager = new ImageManager(new Driver());

          // Décodage et création de l'image
          $image = $manager->read($cover_event) ;
          
         // cover a size of 300x300 and position crop on the left
          $image->cover(300, 300, 'center'); // 300 x 300 px
            
             
          $destinationPath=public_path('cover_recommanded');
          if(!file_exists($destinationPath)){
              mkdir($destinationPath,0775,true);
          }
          $fileName=time(). '_cover_'.str_replace(' ','_',$evenement->nom_evenement).'_recommanded.jpg';
          $image->save($destinationPath.'/'.$fileName);
          $imagePath='cover_recommanded/' . $fileName;
          $evenement->cover_recommanded=$imagePath;
        }
        $evenement->recommanded=true;
        $evenement->save();
        return response()->json([
            "success"=>true,
            "status"=>true,
            "message"=>"evenement recommandé"
        ]);
      }
        
    }
   
}
  
    public function Same_organiser($organiser){
      $evenements=evenement::where('profil_promoteur_id',$organiser)->get();
      return view('administrative.evenement.index',compact('evenements'));
  }

  public function filtered_event($filter,$filter_character){
    if($filter_character=='isOnline'){
      $evenements=evenement::where($filter_character,$filter)->get();
    }
    elseif($filter_character=='administrative_status'){
      $evenements=evenement::where($filter_character,$filter)->get();
    }
    elseif($filter_character=='recommanded'){
      $evenements=evenement::where($filter_character,$filter)->get();
    }
    
    return view('administrative.evenement.index',compact('evenements'));
  }

  public function users(){
    $users=User::role(['Promoteur','User'])->get();
    $promoteurs=User::role('Promoteur')->get();
    
    return view('administrative.evenement.users',compact('users','promoteurs'));
  }

  public function UserActivity($user){
    $user=User::find($user);
    return view('administrative.evenement.UserActivity',compact('user'));
  }

  public function dashboard(){
    return view('administrative.evenement.dashboard');
  }

  public function AdminShowEvent(evenement $evenement){
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
    return view('administrative.evenement.adminShowEvent', compact('evenement', 'date','organisateur','chronogramme', 'ticket', 'same_creator','intervenants'));        
  }

  public function getChartsDataAdmin(Request $request){
      $users=User::withTrashed()->get();
      $promoteurs=Profil_promoteur::all();
      $user_periode=$request->user_periode;
      $promoteur_periode=$request->promoteur_periode;
      $dateInscriptions=array();
      $nbrInscriptionPerDay=array();
      $nbrTotalPerDay=array();
      if($user_periode==7){
        for($i=$user_periode; $i>=0; $i--){
          $date=Carbon::now()->subDays($i);
          $dateInscriptions[]=date('d/m/Y',strtotime($date)); 
          $dateForEaches[]=$date;
        }
      }
      foreach ($dateForEaches as $key => $dateForEach) {
        $nbreInscription=count($users->where('created_at','>=',$dateForEach->startofDay())->where('created_at','<=',$dateForEach->endofDay()));
        $nbrInscriptionPerDay[]=$nbreInscription;
      }
      foreach ($dateForEaches as $key => $dateForEach) {
        $nbreDesinscription=count($users->where('deleted_at','>=',$dateForEach->startofDay())->where('created_at','<=',$dateForEach->endofDay()));
        $nbrDesinscriptionPerDay[]=$nbreDesinscription;
      }
      foreach ($dateForEaches as $key => $dateForEach) {
        $nbreInscription=count($users->where('created_at','>=',$dateForEach->startofDay())->where('created_at','<=',$dateForEach->endofDay()));
        $nbreDesinscription=count($users->where('deleted_at','>=',$dateForEach->startofDay())->where('created_at','<=',$dateForEach->endofDay()));
        $Total= $nbreInscription-$nbreDesinscription;
        $nbrTotalPerDay[]=$Total;
      }

      $cliqueurs=User::whereHas('evenements',function ($query){
        $query->where('nombre_click', true);
      })->whereDoesntHave('tickets')->count();
      
      $acheteur_unique= User::whereHas('tickets.type_ticket.evenement',function ($query) {
        $query->groupBy('evenement_id')
              ->havingRaw('COUNT(DISTINCT evenement_id) = 1');
    })->count();
     
      $acheteur_multiple=$users = DB::table('users')
    ->join('tickets', 'users.id', '=', 'tickets.user_id')
    ->join('type_tickets', 'tickets.type_ticket_id', '=', 'type_tickets.id')
    ->join('evenements', 'type_tickets.evenement_id', '=', 'evenements.id')
    ->select('users.id', 'users.name')
    ->groupBy('users.id', 'users.name')
    ->havingRaw('COUNT(DISTINCT evenements.id) > 1')
    ->count();

    $fantomes= User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })
        ->leftJoin('evenement_user', 'users.id', '=', 'evenement_user.user_id')
        ->leftJoin('tickets', 'users.id', '=', 'tickets.user_id')
        ->whereNull('evenement_user.user_id')
        ->whereNull('tickets.user_id')
        ->select('users.*')
        ->count();
        


        $user_segmentation= [$cliqueurs,$acheteur_unique,$acheteur_multiple,$fantomes];

        if($promoteur_periode==7){
          for($i=$promoteur_periode; $i>=0; $i--){
            $date=Carbon::now()->subDays($i);
            $datePromoteurs[]=date('d/m/Y',strtotime($date)); 
            $dateForEachesPromoteurs[]=$date;
          }
        }
        foreach ($dateForEachesPromoteurs as $key => $dateForEach) {
          $nbrePromoteur=count($promoteurs->where('created_at','>=',$dateForEach->startofDay())->where('created_at','<=',$dateForEach->endofDay()));
          $nbrPromoteurPerDay[]=$nbrePromoteur;
        }
        
        $promoteur_unique = evenement::select('profil_promoteur_id')
                            ->groupBy('profil_promoteur_id')
                            ->havingRaw('COUNT(*) = 1')
                            ->count();
        $promoteur_multiple=evenement::select('profil_promoteur_id')
                            ->groupBy('profil_promoteur_id')
                            ->havingRaw('COUNT(*) > 1')
                            ->count();
        $promoteur_fantome=Profil_promoteur::whereDoesntHave('evenements')->count();

        $promoteur_segmentation=[$promoteur_multiple,$promoteur_unique,$promoteur_fantome];

        $sold_out = evenement::where('isOnline', 1)
                    ->whereHas('type_tickets', function ($query) {
                        $query->havingRaw('SUM(place_dispo) = 0');
                    })
                    ->count();
        $half_sold = evenement::where('isOnline', 1)
                    ->whereHas('type_tickets', function ($query) {
                        $query->havingRaw('SUM(quantite-place_dispo) >= SUM(quantite/2)')
                              ->havingRaw('SUM(place_dispo) > 0');
                    })
                    ->count();
        $minor_sold= evenement::where('isOnline', 1)
                      ->whereHas('type_tickets', function ($query) {
                          $query->havingRaw('SUM(quantite-place_dispo) < SUM(quantite/2)');
                      })
                      ->count();
      
        $evenement_segmentation=[$sold_out,$half_sold,$minor_sold];
        $Total_user=User::all()->count();
      return response()->json([ 
          'DatesInscription'=>$dateInscriptions,
          'NbreInscriptionPerDay'=>$nbrInscriptionPerDay,
          'NbreDesinscriptionPerDay'=>$nbrDesinscriptionPerDay,
          'NbreTotalPerDay'=>$nbrTotalPerDay,
          'user_segmentation'=>$user_segmentation,
          'DatePromoteurs'=>$datePromoteurs,
          'NbrePromoteursPerDay'=>$nbrPromoteurPerDay,
          'promoteur_segmentation'=>$promoteur_segmentation,
          'evenement_segmentation'=>$evenement_segmentation,
          'total_user'=>$Total_user,
      ]);
  }


}
