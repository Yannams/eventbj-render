@extends('layout.promoteur')
    @section('content')
    <div class="container">
        
            <form action="{{route('type ticket.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                <div class="col-12 ">
                    <label for="image_ticket">Choisir un cover pour les tickets</label>
                    <input type="file" name="image_ticket" id="image_ticket" class="form-control">
                </div>
                <div class="col-12 ">
                    <label for="nom_ticket">Nom ticket</label>
                    <input type="text" name="nom_ticket" id="nom_ticket" class="form-control">
                </div><div class="col-2">
                    <label for="type_ticket">type_ticket</label>
                    <select name="type_ticket" id="type_ticket" class="form-control">
                        <option value="ticket payé">ticket payé</option>
                        <option value="Invitation">Invitation</option>
                        <option value="Don">Don</option>

                    </select>
                </div>
                
                <div class="col-sm-4">
                    <label for="prix_ticket">Prix ticket</label>
                    <input type="number" name="prix_ticket" id="prix_ticket" class="form-control">
                </div>
                <div class="col-sm-4">
                    <label for="frais_ticket">frais prélevée</label>
                    <input type="number" name="frais_ticket" id="frais_ticket" class="form-control">
                </div>
                
                <div class="col-sm-4">
                    <label for="place_dispo">Nombre de place</label>
                    <input type="number" name="place_dispo" id="place_dispo" class="form-control" >
                </div>
                <input type="hidden" name="evenement_id" id="evenement_id" value="{{$evenement_id}}">
                <button type="submit" class="btn btn-primary">suivant</button>
                </div>
            </form> 
       
       
    </div>
    @endsection