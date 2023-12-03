@extends('layout.utilisateur')
    @section('content')
        <div class="card border-0">
            <div class="card-body">
                <h1>Billeterie</h1>
                <div class="d-flex">
                    <h2 class="p-2 w-75">Ticket {{$type_ticket->nom_ticket}}</h2>
                    <div class="p-2 fw-bold fs-3">{{$type_ticket->prix_ticket}} XOF | Frais: {{($type_ticket->prix_ticket*1.9)/100}} XOF</div>
                </div>
                <div class="row">
                    <div class="col-2">
                         <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button"><svg class="bi bi-dash-lg" fill="#000000" onclick="decreaseValue()" width="30" height="30"><use xlink:href="#dash"></use></svg></button>
                            <input type="number" class="form-control" name="nombre_ticket" id="nombre_ticket" class="form-control" min="0" value="0" readonly>
                            <button class="btn btn-outline-secondary" type="button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><svg class="bi bi-plus border-3" fill="#000000" width="30" onclick="increaseValue()" height="30"><use xlink:href="#plus"></use></svg></button>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="collapseExample">
                    <div class="card card-body">
                      Some placeholder content for the collapse component. This panel is hidden by default but revealed when the user activates the relevant trigger.
                    </div>
                  </div>
                
                <form action="{{route('paiementKkia')}}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">   
                            <label for="prix_ticket">Prix ticket</label>
                            <input type="text" name="prix_ticket" id="prix_ticket" class="form-control" value="{{$type_ticket->prix_ticket}}" readonly>
                        </div>
                        <div class="col-12">   
                            <label for="nombre_ticket">Nombre ticket</label>
                            <input type="number" name="nombre_ticket" id="nombre_ticket" class="form-control" min="0" value="0"  > 
                        </div>
                        <div class="col-12">   
                            <label for="total">Net à payer</label>
                            <input type="number" name="total" id="total" class="form-control" readonly>
                        </div>
                        <input type="hidden" name="id_type_ticket" value="{{$type_ticket->id}}">
                        <button type="submit" class="btn btn-primary kkiapay-button">Obtenir</button>
                    </div>
                    
                    
                    
                   
                    
                    <script>
                        var prixTicketinput = document.getElementById("prix_ticket");
                        var nombreTicketinput = document.getElementById("nombre_ticket");
                        var netApayerinput = document.getElementById("total");
                    
                        prixTicketinput.addEventListener("input", updateNetApayer);
                        nombreTicketinput.addEventListener("input", updateNetApayer);
                    
                        function updateNetApayer() {
                            var prixTicket = parseFloat(prixTicketinput.value);
                            var nombreTicket = parseFloat(nombreTicketinput.value);
                    
                            if (!isNaN(prixTicket) && !isNaN(nombreTicket)) {
                                var resultat = prixTicket * nombreTicket;
                                netApayerinput.value = resultat;
                    
                                // Mettez à jour l'attribut 'amount' dans le script en bas avec la valeur calculée
                                document.querySelector('script[src="https://cdn.kkiapay.me/k.js"]').setAttribute('amount', resultat);
                            } else {
                                netApayerinput.value = "";
                    
                                // Réinitialisez l'attribut 'amount' dans le script en bas si les valeurs ne sont pas valides
                                document.querySelector('script[src="https://cdn.kkiapay.me/k.js"]').removeAttribute('amount');
                            }
                        }
                    </script>
                    <script>
                        function increaseValue() {
                            var inputElement = document.getElementById('nombre_ticket');
                            inputElement.value = parseInt(inputElement.value) + 1;
                        }
                    
                        function decreaseValue() {
                            var inputElement = document.getElementById('nombre_ticket');
                            var currentValue = parseInt(inputElement.value);
                            if (currentValue > 0) {
                                inputElement.value = currentValue - 1;
                            }
                        }
                    </script>
                    
                    
      
        <script amount=""  callback="{{route('ticket.store')}}" data="" position="center"  theme="#0095ff" sandbox="true" key="d996a8407a9111eea7c1213b731c024f" src="https://cdn.kkiapay.me/k.js"></script>
    </form>
            </div>
           
        </div>
        

       
    @endsection