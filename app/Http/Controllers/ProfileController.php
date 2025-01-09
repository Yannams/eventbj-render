<?php

namespace App\Http\Controllers;

use App\Models\evenement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function afficherProfil ()
    { 
        return view('auth.gererProfil');
    }
    
    public function afficherProfilPromoteur ()
    { 
        return view('auth.gererProfilPromoteur');
    }
   
}
