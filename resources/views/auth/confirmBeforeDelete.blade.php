@extends('layout.utilisateur')
    @section('content')
        <div class="card border-0">
            <div class="card-body px-5">
                <h4 class="fw-bold mb-3">Supprimer le compte</h4>
                <form action="{{route('softDelete')}}" method="POST">
                    @csrf
                    <div>
                        
                        <input type="password" name="password" id="password" class="form-control">
                        <input type="hidden" name="user_id" value="{{$user->first()->id}}">
                        <div class="justify-content-end d-flex"><button class="btn btn-success mt-3">Valider</button></div>
                    </div>
                   
                </form>
                
            </div>

        </div>
    @endsection