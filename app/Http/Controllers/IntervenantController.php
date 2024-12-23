<?php

namespace App\Http\Controllers;

use App\Models\Intervenant;
use App\Http\Requests\StoreIntervenantRequest;
use App\Http\Requests\UpdateIntervenantRequest;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

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
        $photo_intervenant_cropped=$request->photo_intervenant_cropped;
        if($request->photo_intervenant_cropped)
        {
            list($type, $photo_intervenant_cropped) = explode(';', $photo_intervenant_cropped);
            list(, $photo_intervenant_cropped)      = explode(',', $photo_intervenant_cropped);
            $photo_intervenant_cropped = base64_decode($photo_intervenant_cropped);
            $manager = new ImageManager(new Driver());
    
            // Décodage et création de l'image
            $image = $manager->read($photo_intervenant_cropped) ;
        
            // Redimensionnement proportionnel avec une largeur maximale de 800px sans agrandir l'image
            $image = $image->scaleDown(width: 800);
        
            // Encodage de l'image en JPEG avec une qualité de 70%
            $encoded = $image->toJpeg(95); 
               
            $destinationPath=public_path('profil_intervenant');
            if(!file_exists($destinationPath)){
                mkdir($destinationPath,0775,true);
            }
            $fileName=time(). '_cover_'.str_replace(' ','_',$request->nom_intervenant).'.jpg';
            $encoded->save($destinationPath.'/'.$fileName);
            $imagePath='profil_intervenant/' . $fileName;
            $intervenant->photo_intervenant=$imagePath; 
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
        $photo_intervenant_cropped=$request->photo_intervenant_cropped_edit;
        if($request->photo_intervenant_cropped_edit)
        {
            list($type, $photo_intervenant_cropped) = explode(';', $photo_intervenant_cropped);
            list(, $photo_intervenant_cropped)      = explode(',', $photo_intervenant_cropped);
            $photo_intervenant_cropped = base64_decode($photo_intervenant_cropped);
            $manager = new ImageManager(new Driver());
    
            // Décodage et création de l'image
            $image = $manager->read($photo_intervenant_cropped) ;
        
            // Redimensionnement proportionnel avec une largeur maximale de 800px sans agrandir l'image
            $image = $image->scaleDown(width: 800);
        
            // Encodage de l'image en JPEG avec une qualité de 70%
            $encoded = $image->toJpeg(95); 
               
            $destinationPath=public_path('profil_intervenant');
            if(!file_exists($destinationPath)){
                mkdir($destinationPath,0775,true);
            }
            $fileName=time(). '_cover_'.str_replace(' ','_',$request->nom_intervenant).'.jpg';
            $encoded->save($destinationPath.'/'.$fileName);
            $imagePath='profil_intervenant/' . $fileName;
            $intervenant->photo_intervenant=$imagePath; 
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
