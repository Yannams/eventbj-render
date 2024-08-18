<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RBACRedirectionController extends Controller
{
    public function redirection(){
        if (auth()->user()->hasRole('User')) {
            return redirect()->route('evenement.index');
        } elseif (auth()->user()->hasRole('Promoteur')) {
            return redirect()->route('MesEvenements');
        }elseif (auth()->user()->hasRole('Admin')) {
            return redirect()->route('AllEvents');
        }
    }
    
}
