<?php

namespace App\Http\Controllers;

use App\Models\evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function afficherFormulaire (Request $request)
    {
       
            if(Auth::check())
            {
                $user= auth()->user()->isEntreprise;
                if($user == false)
                {
                    return redirect()->route('select_type_lieu');
                }
                elseif ($user == true) {
                    return redirect()->route('select_type_lieu');
                }
                else {
                    return view('auth.isEntreprise');
                }
            }
             else {
                 return view('auth.login');
             }
    
       
    }
    public function updateIsEntreprise(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $user->isPromoteur=true;
            if($request->isEntreprise == "true")             
            {
                $user->isEntreprise = true;
                $user->save();
                return redirect()->route('select_type_lieu');
            }
            elseif ($request->isEntreprise == "false") {
                $user->isEntreprise = false;
                $user->save();
                return redirect()->route('select_type_lieu');
            }
            else{
                return redirect()->route('isEntreprise')->with('error','veuillez sélectionné de nouveau');
            }
            
        }
        else{
            return redirect()->route('login');
        }
    }
}
