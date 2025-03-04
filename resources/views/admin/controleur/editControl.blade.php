@extends('layout.promoteur')
    @section('content')
        <div class="card border-0 shadow">
            <div class="card-body">
                <h3 class="fw-bold">{{$controleur->ControleurId}}</h3>
                <form action="{{route('updateControle',['controleur'=>$evenement_controleur->controleur_id,'evenement'=>$evenement_controleur->evenement_id])}}" method="POST" onsubmit="disableSubmitButton(this)">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="name">Nom du controleur</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{$evenement_controleur->name}}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="telephone">Numéro du controleur</label>
                            <input type="number" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{$evenement_controleur->telephone}}">
                            @error('telephone')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                        <div class="col-12 mb-3">
                            <label for="email">email du controleur</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{$evenement_controleur->email}}">
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
                                    <option value="{{$evenement->id}}" @if($evenement->id==$evenement_controleur->evenement_id) selected @endif>{{$evenement->nom_evenement}}</option>
                                @endforeach
                            </select>
                            @error('evenement_id')
                                <div class="invalid-feedback">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success" id="submitButton">Modifier</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
             function disableSubmitButton(form) {
                    form.querySelector('#submitButton').disabled = true;
                }   
        </script>
       
    @endsection
   