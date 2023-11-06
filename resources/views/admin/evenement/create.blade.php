@extends('layout.promoteur')
    @section('content')
    <div class="container">
        <form action="{{route('evenement.store')}}" method="post" enctype="multipart/form-data">
           @csrf
                
                <div class="col-12 mb-3">
                    <label for="cover_event">Choisir une cover</label>
                    <input type="file" name="cover_event" id="cover_event" class="form-control">
                </div>
                <div class="col-12 mb-3">
                    <label for="nom_evenement">Nom evenement</label>
                    <input type="text" name="nom_evenement" id="nom_evenement" class="form-control">
                </div>
                <div class="col-12 mb-3">
                    <label for="type_evenement_id">Type de l'evenement</label>
                    <select name="type_evenement_id" id="type_evenement_id" class="form-control">
                       @foreach ($type_evenement as $type_evenements )
                            <option value="{{$type_evenements->id}}">{{$type_evenements->nom_type_evenement}}</option>
                       @endforeach 
                        
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label for="localisation">Localisation</label>
                    <input type="text" name="localisation" id="localisation" class="form-control">
                </div>
                <div class="col-12 mb-3">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                </div>
                <div></div>
                <input type="hidden" name="type_lieu_selected" value="{{$typeLieuId}}">
                <div class="col-12 mb-3">
                    <button type="submit" class="btn btn-primary">Suivant</button>    
                </div>
            
        </form>
    </div>    
    @endsection
