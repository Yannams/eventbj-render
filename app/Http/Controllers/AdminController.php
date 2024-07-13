<?php

namespace App\Http\Controllers;

use App\Models\evenement;
use App\Models\User;
use Illuminate\Http\Request;

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
    $users=User::all();
    return view('administrative.evenement.users',compact('users'));
  }

  public function UserActivity($user){
    $user=User::find($user);
    return view('administrative.evenement.UserActivity',compact('user'));
  }

  public function dashboard(){
    return view('administrative.evenement.dashboard');
  }
}
