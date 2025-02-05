<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RBACRedirectionController extends Controller
{
    public function redirection(){
        if (url()->previous()==route('register')){
            return redirect()->route('Centre_interet.index');
        }else {
            if (auth()->user()->hasRole('User')) {
                return redirect()->route('evenement.index');
            } elseif (auth()->user()->hasRole('Promoteur')) {
                return redirect()->route('MesEvenements');
            }elseif (auth()->user()->hasRole('Admin')) {
                return redirect()->route('AllEvents');
            }elseif(auth()->user()->hasRole('Controleur')){
                return redirect()->route('controleurAcess');
            }
        }
      
    }
    
    // public function SelectInterest(){
    //     return view('layout.SelectInterest');
    // }
}
