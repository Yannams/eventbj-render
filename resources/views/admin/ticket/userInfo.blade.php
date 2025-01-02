@extends('layout.utilisateur')
    @section('content')
        <div class="container">
            <div class="card border-0 shadow">
                <div class="card-body">
                    <form action="{{route('GetUserInfo')}}" method="POST">
                        @csrf
                        <h4 class="fw-bold mb-2">Enregistrer vos informations de paiement</h4>
                        <div class="row mb-2">
                            <label for="lastname" class="col-12 col-form-label text-start">{{ __('Nom') }}</label>
                            <div class="col-12">
                                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{$userInfo['lastname']?: old('firstname') }}" required autocomplete="lastname" autofocus>

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="firstname" class="col-12 col-form-label text-start">{{ __('Prénom') }}</label>
                            <div class="col-12">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{$userInfo['firstname'] ?: old('firstname') }}" required autocomplete="firstname" autofocus>

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-2">
                            <label for="email" class="col-12 col-form-label text-start">{{ __(' Adresse email') }}</label>

                            <div class="col-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$userInfo['email']?: old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="number" class="col-12 col-form-label text-start">{{ __('Numéro') }}</label>

                            <div class="col-12">
                                <input id="number" type="number" class="form-control @error('number') is-invalid @enderror" name="number" value="{{$userInfo['phone_number']['number']?: old('number') }}" required >

                                @error('number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Suivant</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection