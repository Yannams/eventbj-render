@extends('layout.utilisateur')
    @section('content')
    <form action="{{route('Centre_interet.store')}}" class="text-center" method="POST" onsubmit="disableSubmitButton(this)">
        @csrf
        <h1 class=" fw-bold mb-1">Dites-nous ce qui vous passionne ! <h1>
        <h3 class=" fw-semibold mb-5">Cela nous permettra de vous proposer des évènements à votre goût !</h3>
        <div class="d-flex align-items-center" style="">
            <div class="container text-center">
                @foreach ($centre_interets as $centre_interet )
                    <span class="me-1">
                        <input type="checkbox" class="btn-check" id="Interest-{{$centre_interet->id}}" value="{{$centre_interet->id}}" name="interest[]" autocomplete="off">
                        <label class="btn btn-outline-success rounded-pill mb-2" for="Interest-{{$centre_interet->id}}">{{$centre_interet->nom_ci}}</label>
                    </span>
                @endforeach
            </div>
        </div>
        <button type="submit" id="submitButton" class="mt-5 rounded-pill btn btn-danger">Continuer <i class="bi bi-arrow-right-circle-fill"></i></button>
    </form>
    <script>
          function disableSubmitButton(form) {
                    form.querySelector('#submitButton').disabled = true;
                }
    </script>
    @endsection