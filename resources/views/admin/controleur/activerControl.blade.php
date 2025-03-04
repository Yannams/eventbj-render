@extends('layout.promoteur')
    @section('content')
        <div class="container mt-5">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form action="{{route('executeActivation')}}" method="post" onsubmit="disableSubmitButton(this)">
                        @csrf
                        <input type="hidden" name="controleur_id" value="{{$controleur->id}}">
                        <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
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
                            <button type="submit" class="btn btn-success" id="submitButton">Activer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script>
             function disableSubmitButton(form) {
                form.querySelector('#submitButton').disabled = true;
            }
        </script>
    @endsection