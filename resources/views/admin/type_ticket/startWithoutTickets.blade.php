@extends('layout.promoteur')
    @section('content')
    <div class="container d-flex align-items-center justify-content-center" style="height: 500px">
            <div class="card border-0 shadow p-3">
                <div class="card-body">
                    <div class="text-center">Vous n'avez pas de billetterie.</div>
                    <div>Voulez-vous continuer ?</div>
                    <div class="d-flex justify-content-end mt-5">
                        <a href="{{route('AddTicket',$evenement->id)}}" class="btn btn-outline-success">Ajouter une billetterie</a>
                        <form action="{{route('OnlineEvents')}}" method="post">
                            @csrf
                            <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
                            <input type="hidden" name="form" value="form">
                            <button class="btn btn-success ms-2">Continuer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection