@extends('layout.promoteur')
    @section('content')
        <div class="card border-0 shadow">
            <div class="card-body">
                <h3 class="fw-bold">{{$controleur->ControleurId}}</h3>
                <form action="{{route('controleur.update',$controleur)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="name">Nom du controleur</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="telephone">Numéro du controleur</label>
                            <input type="number" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{old('telephone')}}">
                            @error('telephone')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="email">email du controleur</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="evenement_id">Evenement</label>
                            <select name="evenement_id" id="evenement_id" class="form-select @error('evenement_id') is-invalid @enderror">
                                <option value=""></option>
                                @foreach ($evenements as $evenement)
                                    <option value="{{$evenement->id}}" @if($evenement->id==old('evenement_id')) selected @endif>{{$evenement->nom_evenement}}</option>
                                @endforeach
                            </select>
                            @error('evenement_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="password">Mot de passe </label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="password_confirmation">Confirmer mot de passe </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Activer</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endsection