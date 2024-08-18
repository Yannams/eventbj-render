<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersoftdeleteController extends Controller
{
   public function softDelete(Request $request){
        $user=$request->user_id;
        $password=$request->password;
        
       $user= User::find($user);
       if(Hash::check($password, $user->password)){
          $user->delete();
          Auth::logout();
          Session::flush();
          return redirect()->route('login');
       }
   }

   public function ConfirmUserBeforeDelete(User $user){
     $user=User::find($user);

        return view('auth.confirmBeforeDelete',compact('user'));
   }
}
