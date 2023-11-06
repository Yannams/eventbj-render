@extends('layout.promoteur')
    @section('content')
        <form action="{{route('type_lieu.store')}}" method="post">
            @csrf
            <div class="col-12">
                <label for="nom_type">Nom du type de lieu</label>
                <input type="text" name="nom_type" id="nom_type" class="form-control">
            </div>  
            <div class="col-12">
                <label for="description">Description</label>
                <textarea name="description" id="nom_type" cols="30" rows="10" class="form-control"></textarea>
            </div>    
            <button type="submit">Créer</button>        
        </form>
    @endsection
