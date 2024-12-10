<?php

namespace App\Http\Controllers;

use App\Models\Intervenant;
use App\Http\Requests\StoreIntervenantRequest;
use App\Http\Requests\UpdateIntervenantRequest;
use Illuminate\Http\Request;

class IntervenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {    
        $evenement_id=$_GET['event'];
        $intervenants=Intervenant::where('promoteur_id',auth()->user()->Profil_promoteur->id)
        ->where('evenement_id',$evenement_id)
        ->get();
        return view('admin.intervenant.index',compact('evenement_id','intervenants'));
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
    public function store(StoreIntervenantRequest $request)
    {
        $intervenant=new Intervenant;
        $intervenant->nom_intervenant=$request->nom_intervenant;
        $intervenant->role_intervenant=$request->role_intervenant;
        $intervenant->promoteur_id=$request->promoteur_id;
        $intervenant->evenement_id=$request->evenement_id;
        if($request->hasFile('photo_intervenant'))
        {
            $image = $request->file('photo_intervenant');
            $destinationPath = public_path('profil_intervenant'); // Le chemin de destination où vous souhaitez déplacer le fichier

            // Assurez-vous que le répertoire de destination existe
            if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0755, true);
            }
    
            $fileName = time() . '_' . $image->getClientOriginalName(); // Générez un nom de fichier unique si nécessaire
    
            $image->move($destinationPath, $fileName); // Déplacez le fichier vers le répertoire de destination
    
            // Maintenant, $destinationPath.'/'.$fileName contient le chemin complet du fichier déplacé
            $imagePath='profil_intervenant/'.$fileName;
            $intervenant->photo_intervenant= $imagePath;
        } 
        else
        {
            $intervenant->photo_intervenant= 'aucune image';
        }
        $intervenant->save();
        return redirect()->route('Intervenant.index',['event'=>$intervenant->evenement_id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Intervenant $intervenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Intervenant $intervenant)
    {
        $intervenant=Intervenant::find($_GET['intervenant_id']);
        return response()->json([
            'nom_intervenant'=>$intervenant->nom_intervenant,
            'role_intervenant'=>$intervenant->Role_intervenant,
            'promoteur_id'=>$intervenant->promoteur_id,
            'evenement_id'=>$intervenant->evenement_id,
            'photo_intervenant'=>$intervenant->photo_intervenant,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIntervenantRequest $request, Intervenant $intervenant)
    { 
      
        $intervenant=Intervenant::find($request->intervenant_id);
        $intervenant->nom_intervenant=$request->nom_intervenant;
        $intervenant->Role_intervenant=$request->role_intervenant;
        if($request->hasFile('photo_intervenant'))
        {
            $image = $request->file('photo_intervenant');
            $destinationPath = public_path('profil_intervenant'); // Le chemin de destination où vous souhaitez déplacer le fichier

            // Assurez-vous que le répertoire de destination existe
            if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0755, true);
            }
    
            $fileName = time() . '_' . $image->getClientOriginalName(); // Générez un nom de fichier unique si nécessaire
    
            $image->move($destinationPath, $fileName); // Déplacez le fichier vers le répertoire de destination
    
            // Maintenant, $destinationPath.'/'.$fileName contient le chemin complet du fichier déplacé
            $imagePath='profil_intervenant/'.$fileName;
            $intervenant->photo_intervenant= $imagePath;
        } 
        $intervenant->save();
        return redirect()->route('Intervenant.index',['event'=>$intervenant->evenement_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Intervenant $intervenant)
    {
        $intervenant_id=$request->intervenant_id;
        $intervenant=Intervenant::find($intervenant_id);
        $evenement_id=$intervenant->evenement_id;
        $intervenant->delete();
        return redirect()->route('Intervenant.index',['event'=>$evenement_id]);
    }
}
