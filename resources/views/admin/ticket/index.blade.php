@extends('layout.utilisateur')
    @section('content')
        @foreach ($ticket as $tickets)
            <h1>{{$tickets->id}}</h1>
            
        @endforeach
    @endsection