@extends('layout.utilisateur')
    @section('content')
    <iframe 
        src="{{$type_ticket->event_link}}" 
        style="width: 100%; height: 90vh; border: none;" 
        allow="camera; microphone">
    </iframe>
    @endsection