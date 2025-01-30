@extends('layout.utilisateur')
    @section('content')
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <strong role="status">Création de votre <span style="color:  #F0343C;">BJ</span><span style="color: #FBAA0A; ">-</span> <span style="color: #308747">ticket</span></strong>
                    <div class="spinner-border ms-auto" aria-hidden="true"></div>
                </div>
                <p></p>

                <form id="monFormulaire" action="{{route('ticket.store')}}" method="post">
                    @csrf
                   <input type="hidden" name="id_type_ticket" value="{{$type_ticket_id}}"> 
                    <input type="hidden" name="transaction_id" value="{{$transaction_id}}">
                    <input type="hidden" name="nbr" value="{{$nbr}}">
                    <!-- Pas de bouton de soumission ici -->
                </form>
            
                <script>
                    // Écouteur d'événement pour le formulaire
                    document.addEventListener("DOMContentLoaded", function() {
                        // Déclencher la soumission automatique du formulaire
                        document.getElementById("monFormulaire").submit();
                    });
                </script>
            </div>
        </div>
    @endsection