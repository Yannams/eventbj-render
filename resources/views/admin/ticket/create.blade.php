@extends('layout.utilisateur')
    @section('content')
        <div class="card border-0 shadow">
            <div class="card-body">
                <h1>Billeterie</h1>
                <div class="d-flex"> 
                    <h2 class="p-2 w-75" id="nom_ticket">Ticket {{$type_ticket->nom_ticket}}</h2>
                    <div class="p-2 fw-bold fs-3" id="prix_ticket">{{$type_ticket->prix_ticket}} XOF | Frais: {{($type_ticket->prix_ticket*1.9)/100}} XOF</div>
                </div>
                <div class="row">
                    <div class="col-2">
                         <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button"><svg class="bi bi-dash-lg" fill="#000000" onclick="decreaseValue()" width="30" height="30"><use xlink:href="#dash"></use></svg></button>
                            <input type="number" class="form-control" name="nombre_ticket" id="nombre_ticket" class="form-control" min="0" value="0" disabled>
                            <button class="btn btn-outline-secondary" type="button" ><svg class="bi bi-plus border-3" fill="#000000" width="30" onclick="increaseValue()" height="30"><use xlink:href="#plus"></use></svg></button>
                        </div>
                        <div class="invalidNbreTicket text-danger">

                        </div>
                    </div>
                </div>
                <h3 class="col">Resume de la commande </h3>
                <hr>
                <div id="resume" class="col">
                    <div class="row">
                       
                    </div>
                    
                    
                </div>
                <form class="formulaire2" method="post" onsubmit="return false;">
                   
                    <input type="hidden" name="montant" value="">
                    <button type="submit" class="btn btn-success col-12">Obtenir</button>
                </form>
                
                <script>
                   var formulaire2 = document.querySelector(".formulaire2");

                    formulaire2.addEventListener("submit", function(e) {
                        e.preventDefault();

                        var nombreTicket = $('#nombre_ticket').val();
                       
                        
                        if (nombreTicket > 0) {
                            
                            var dataToSend = {
                                nombreTicket: nombreTicket
                            };


                            $.ajax({
                                url: "/NombreTicket" ,
                                type: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                dataType: 'json',
                                data: dataToSend,
                                success: function(data) {
                                    console.log('Réponse réussie:', data);

                                    // Appeler initializeApp après un succès de la requête
                                    initializeApp("{{ route('verifiedTransation', ['type_ticket' => $type_ticket->id]) }}",data.name,data.email,data.numero);
                                },
                                error: function(error) {
                                    console.log('Erreur:', error);
                                }
                            });
                        } else {
                            console.log(nombreTicket);
                            $('.invalidNbreTicket').html('Le nombre de tickets doit être supérieur à 0');
                        }
                    });

                

                    function initializeApp(callbackUrl,name,email,numero) {
                        
                        
                        openKkiapayWidget({
                            amount: formulaire2.querySelector("[name='montant']").value,
                            position: "center",
                            callback: callbackUrl,
                            data: "",
                            theme: "#308747",
                            name:name,
                            email:email,
                            phone:numero,
                            sandbox: true,
                            key: "33a40fc0652511efbf02478c5adba4b8"
                        });
                    }
                </script>
                
                {{-- @vite('resources/js/app.js')
                <script>
                    window.ticketStoreRoute = "{{ route('ticket.store') }}";
                </script>
                <script>
                    initializeApp("{{ route('ticket.store') }}");
                </script> --}}
              

                <script>
                    function increaseValue() {
                                var inputElement = document.getElementById('nombre_ticket');
                                inputElement.value = parseInt(inputElement.value) + 1;
                                var nbre_ticket = document.getElementById('nombre_ticket').value;
                                var prix_ticket = parseInt(document.getElementById('prix_ticket').innerText);
                                var resumeDiv = document.getElementById('resume');
                                var total = nbre_ticket * prix_ticket;
                                var frais = (total * 1.9) / 100;
                                var NaP = total + frais;
                                var resume = '<div class="col d-flex ms-3"><span class="fw-bold p-2 w-75" >' + nbre_ticket + 'x {{$type_ticket->nom_ticket}} :</span> <span class="p-2">' + total + '</div> <hr> <div class="col d-flex ms-3"><span class="fw-bold p-2 w-75">Frais :</span><span class="p-2">' + frais + '</span> </div><hr><div class="col d-flex ms-3"><span class="fw-bold p-2 w-75">total :</span><span class="p-2 id="netApayer"">' + NaP + '</span></div>';
                                resumeDiv.innerHTML = resume;
                                document.querySelector('input[name="montant"]').setAttribute('value', total);
                            }

                    
                
                    function decreaseValue() {
                        var inputElement = document.getElementById('nombre_ticket');
                        var currentValue = parseInt(inputElement.value);
                        var resumeDiv = document.getElementById('resume');
                        if (currentValue > 0) {
                                inputElement.value = currentValue - 1;
                                var nbre_ticket = document.getElementById('nombre_ticket').value;
                                var prix_ticket = parseInt(document.getElementById('prix_ticket').innerText);                                    
                                var total = nbre_ticket * prix_ticket;
                                var frais = (total * 1.9) / 100;
                                var NaP = total + frais;
                                var resume = '<div class="col d-flex ms-3"><span class="fw-bold p-2 w-75" >' + nbre_ticket + 'x {{$type_ticket->nom_ticket}} :</span> <span class="p-2">' + total + '</div> <hr> <div class="col d-flex ms-3"><span class="fw-bold p-2 w-75">Frais :</span><span class="p-2">' + frais + '</span> </div><hr><div class="col d-flex ms-3"><span class="fw-bold p-2 w-75">total :</span><span class="p-2" id="netApayer">' + NaP + '</span></div>';
                                resumeDiv.innerHTML = resume;
                                document.querySelector('input[name="montant"]').setAttribute('value', total);
                            }
                            else if(currentValue === 0){
                                resumeDiv.innerHTML = "";
                                document.querySelector('input[name="montant"]').removeAttribute('value');
                            }
                    }
                </script>

        <script src="https://cdn.kkiapay.me/k.js"></script>
  
            </div>
           
        </div>
        
       
    @endsection