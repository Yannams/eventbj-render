@extends('layout.promoteur')
    @section('content')
        <div class="container">
            <form action="{{route('isEntreprise')}}" method="POST">
                @csrf
            <div class="col-4">
                <div class="card ">
                    <input type="radio" name="isEntreprise" id="personnel" value="false">
                    <label for="personnel">pour moi même</label>
                </div>
            </div>
            <div class="col-4">
                <div class="card ">
                    <input type="radio" name="isEntreprise" id="Entreprise" value="true">
                    <label for="Entreprise">Entreprise</label>
                </div>
            </div>
            <button type="submit">Suivant</button>
        </form>
        </div>
    @endsection