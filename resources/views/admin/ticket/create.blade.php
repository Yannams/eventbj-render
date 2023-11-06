@extends('layout.utilisateur')
    @section('content')
        <form action="{{route('ticket.store')}}" method="post">
            @csrf
            <label for="prix_ticket">Prix_ticket</label>
            <input type="text" name="prix_ticket" id="prix_ticket" class="form-control" value="{{$type_ticket->prix_ticket}}" readonly>
            <label for="nombre_ticket">Nombre ticket</label>
            <input type="number" name="nombre_ticket" id="nombre_ticket" class="form-control" min="0" value="0"  > 
            <label for="total">Net à payer</label>
            <input type="number" name="total" id="total" class="form-control" readonly>
            <input type="hidden" name="id_type_ticket" value="{{$type_ticket->id}}">
            <button type="submit" class="btn btn-primary">Obtenir</button>
        </form>

        <script>
            var prixTicketinput = document.getElementById("prix_ticket");
            var nombreTicketinput=document.getElementById("nombre_ticket");
            var netApayerinput=document.getElementById("total");

            prixTicketinput.addEventListener("input", updateNetApayer)
            nombreTicketinput.addEventListener("input", updateNetApayer)
            
            function updateNetApayer() {
                var prixTicket=parseFloat(prixTicketinput.value);
                var nombreTicket=parseFloat(nombreTicketinput.value);

                if(!isNaN(prixTicket) && !isNaN(nombreTicket)){
                    var resultat = prixTicket * nombreTicket;
                    netApayerinput.value=resultat.toFixed(2);
                }else{
                    netApayerinput.value="";
                }
                
            }
        </script>
    @endsection