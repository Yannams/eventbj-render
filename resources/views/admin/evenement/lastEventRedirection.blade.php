@extends('layout.promoteur')
    @section('content')
        <div class="container d-flex align-items-center justify-content-center" style="height: 500px">
            <div class="card border-0 shadow p-3">
                <div class="card-body">
                    <div class="text-center">Vous avez un évènement en cours de création</div>
                    <div>Voulez-vous continuer ?</div>
                    <div class="d-flex justify-content-end mt-5">
                        <a href="{{route('Create_event',session(["Create_new"=>true]))}}" class="btn btn-outline-success">Créer un nouveau</a>
                        <a href="@if($evenement->Etape_creation==1) {{route('select_type_lieu')}} @elseif($evenement->Etape_creation==2) {{route('evenement.edit',$evenement->id)}}  @elseif($evenement->Etape_creation==3){{route('localisation')}} @elseif ($evenement->Etape_creation==4) {{route('type_ticket.create')}} @endif" class="btn btn-success ms-2">Continuer</a>
                    </div>
                </div>
            </div>
        </div>
    @endsection