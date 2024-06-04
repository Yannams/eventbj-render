@extends('layout.promoteur')
    @section('content')
        @foreach ( $evenements as $evenement)
        <form action="{{route('eventSending')}}" method="POST" id="evenement_{{$evenement->id}}">
        @csrf
            <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
        </form>
        <a href="" class="link-underline link-underline-opacity-0 evenementAverifier" data-event-id="{{$evenement->id}}">
            <div class="card eventToVerify">
                <div class="card-body">
                    <div class="row ">
                        <div class="d-flex align-items-center">
                            <div class="col-3">
                                <img src="{{asset($evenement->cover_event)}}" alt="" width="100px" class="rounded-2">
                            </div>
                            <div class="col-3">
                                {{$evenement->nom_evenement}}
                            </div>
                            <div class="col-3">
                                {{date('d/m/Y', strtotime($evenement->date_heure_debut))}}
                            </div>
                            <div class="col-3">
                                {{date('d/m/Y', strtotime($evenement->date_heure_fin))}}
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </a>
        @endforeach
        <script>
            var evenementsAverifier=document.querySelectorAll('.evenementAverifier')
            evenementsAverifier.forEach(function (evenementAverifier) {
                evenementAverifier.addEventListener('click', function verification(event) {
                    event.preventDefault();
                    evenement_id=evenementAverifier.getAttribute('data-event-id');
                    formField=document.getElementById('evenement_'+evenement_id);
                    formField.submit();
                })
            });
        </script>
        
    @endsection