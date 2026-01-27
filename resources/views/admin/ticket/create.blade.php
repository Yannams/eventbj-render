@extends('layout.utilisateur')
    @section('content')
    @if (session('message'))
    <div class="position-relative">
        <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
            <div id="liveToast" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body d-flex align-items-center">
                    <div class="p-2">
                        <svg class="bi bi-check-all" fill="#fff" width="30" height="30">
                            <use xlink:href="#check"></use>
                        </svg>
                    </div>
                    <div class="p-2 fw-bold fs-5">{{session('message')}}</div>
                    <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>    
    </div>
@elseif (session('danger'))
  <div class="position-relative">
    <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
        <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-body d-flex align-items-center">
                <div class="p-2">
                    <svg class="bi bi-trash" fill="#fff" width="30" height="30">
                        <use xlink:href="#deleted"></use>
                    </svg>
                </div>
                <div class="p-2 fw-bold fs-5">{{session('danger')}}</div>
                <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>    
</div>
@elseif (session('error'))
  <div class="position-relative">
      <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
          <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-body d-flex align-items-center">
                  <div class="p-2">
                      <svg class="bi bi-x-circle" fill="#fff" width="30" height="30">
                          <use xlink:href="#error"></use>
                      </svg>
                  </div>
                  <div class="p-2 fw-bold fs-5">{{session('error')}}</div>
                  <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
          </div>
      </div>    
  </div>
@endif
<div class="position-relative" id="AjaxMessage">
</div>
        <div class="card border-0 shadow">
            <div class="card-body">
                <h1>Billeterie</h1>
                <div class="d-flex"> 
                    <h2 class="p-2 w-75" id="nom_ticket">Ticket {{$type_ticket->nom_ticket}}</h2>
                    <div class="p-2 fw-bold fs-3" >{{$type_ticket->prix_ticket}} XOF | Frais: {{($type_ticket->prix_ticket*1.8)/100}} XOF</div>
                </div>
                <div class="row">
                    <div class="col-md-2 col-6">
                         <div class="input-group">
                            <button class="btn btn-outline-secondary" type="button"><svg class="bi bi-dash-lg" fill="#000000" onclick="decreaseValue()" width="30" height="30"><use xlink:href="#dash"></use></svg></button>
                            <input type="number" class="form-control" name="nombre_ticket" id="nombre_ticket" class="form-control" min="0" value="0" max="{{$type_ticket->place_dispo}}" disabled>
                            <button class="btn btn-outline-secondary" type="button" ><svg class="bi bi-plus border-3" fill="#000000" width="30" onclick="increaseValue()" height="30"><use xlink:href="#plus"></use></svg></button>
                        </div>
                        <div class="invalidNbreTicket text-danger">

                        </div>
                    </div>
                </div>
                <h3 class="col">Résumé de la commande </h3>
                <hr>
                <div id="resume" class="col">
                    <div class="row">
                       
                    </div>
                </div>
                <input type="hidden" name="prix_ticket" id="prix_ticket" value="{{$type_ticket->prix_ticket}}">
                <input type="hidden" name="montant" id="montant" value="">
                <input type="hidden" name="format" id="format" value="{{$type_ticket->format}}">
                <div id="submitSpace">
                    @if ($type_ticket->place_dispo > 0)
                        @if ($type_ticket->format=="Ticket")
                            <button type="submit" id="submitButton" 
                                data-transaction-amount=""
                                data-transaction-description="Achat ticket {{$type_ticket->nom_ticket}} de {{$type_ticket->evenement->nom_evenement}}" 
                                data-customer-email="{{auth()->user()->email}}"
                                data-customer-lastname="{{explode(" ",auth()->user()->name)[0] ?? "" }}"
                                data-customer-firstname="{{ explode(" ", auth()->user()->name)[1] ?? "" }}"
                                data-customer-phone_number-number="{{auth()->user()->num_user}}"
                                data-customer-phone_number-country='bj'
                                data-environment="sandbox"
                                data-type-ticket-id="{{$type_ticket->id}}"
                                class="btn btn-success col-12 " disabled>Obtenir</button>
                        @elseif ($type_ticket->format=="Ticket gratuit")
                            <button class="btn btn-success col-12" id="FreeSubmitButton"  data-type-ticket-id="{{$type_ticket->id}}">Obtenir</button>
                        @endif
                    @else
                        <div class="fw-bold fs-3 text-danger">Sold out </div>
                    @endif
                </div>
               
               <div class="contentToSubmit"></div>
                

                <script>
                    function increaseValue() {
                        $('#submitButton').attr('disabled', false);
                        var inputElement =  parseInt($('#nombre_ticket').val());
                        var maxTicket=parseInt($('#nombre_ticket').attr('max'));    
                        if(inputElement < maxTicket){
                             $('#nombre_ticket').val(inputElement + 1);
                            var nbre_ticket =  $('#nombre_ticket').val();
                            var prix_ticket = parseInt($('#prix_ticket').val());
                            var resumeDiv = document.getElementById('resume');
                            var total = nbre_ticket * prix_ticket;
                            var frais = (total * 1.8) / 100;
                            var NaP = total + frais;
                            var resume = '<div class="col d-flex ms-3"><span class="fw-bold p-2 w-75" >' + nbre_ticket + 'x {{$type_ticket->nom_ticket}} :</span> <span class="p-2" id="total">' + total + '</div> <hr> <div class="col d-flex ms-3"><span class="fw-bold p-2 w-75">Frais :</span><span class="p-2">' + frais + '</span> </div><hr><div class="col d-flex ms-3"><span class="fw-bold p-2 w-75">total :</span><span class="p-2 id="netApayer"">' + NaP + '</span></div>';
                            resumeDiv.innerHTML = resume;
                            document.querySelector('input[name="montant"]').setAttribute('value', total);
                           if ($('#format').val()=="Ticket") {
                                submitButton=`<button type="submit" id="submitButton" 
                                                    data-transaction-amount="${total}"
                                                    data-transaction-description="${$("#submitButton").attr("data-transaction-description")}" 
                                                    data-customer-email="${$("#submitButton").attr("data-customer-email")}"
                                                    data-customer-lastname="${$("#submitButton").attr(" data-customer-lastname")}"
                                                    data-customer-firstname="${$("#submitButton").attr("data-customer-firstname")} "
                                                    data-customer-phone_number-number="${$("#submitButton").attr("data-customer-phone_number-number")}"
                                                    data-customer-phone_number-country='bj'
                                                    data-environment="sandbox"
                                                    data-type-ticket-id="${$("#submitButton").attr("data-type-ticket-id")}"
                                                    class="btn btn-success col-12">Obtenir
                                                </button>`  
                                $("#submitSpace").html(submitButton); 
                            }
                            
                        } else {
                            $('#AjaxMessage').html(`
                                <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
                                    <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                                        <div class="toast-body d-flex align-items-center">
                                            <div class="p-2">
                                                <svg class="bi bi-x-circle" fill="#fff" width="30" height="30">
                                                    <use xlink:href="#error"></use>
                                                </svg>
                                            </div>
                                            <div class="p-2 fw-bold fs-5">Il n'y plus assez de ticket disponible</div>
                                            <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                        </div>
                                    </div>
                                </div>    
                            `)
                            const toastLiveExample = document.getElementById('liveToast');

                            if (toastLiveExample) {
                                const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                                toastBootstrap.show();
                            }   
                        }
                               
                    }

                    
                
                    function decreaseValue() {
                        $('#submitButton').attr('disabled', false);
                        var currentValue = parseInt($('#nombre_ticket').val());
                        var resumeDiv = document.getElementById('resume');
                        console.log(currentValue);
                        
                        if (currentValue > 0) {
                                $('#nombre_ticket').val(currentValue - 1);
                                var nbre_ticket = parseInt($('#nombre_ticket').val());
                                var prix_ticket = parseInt($('#prix_ticket').val());                                    
                                var total = nbre_ticket * prix_ticket;
                                var frais = (total * 1.9) / 100;
                                var NaP = total + frais;
                                var resume = '<div class="col d-flex ms-3"><span class="fw-bold p-2 w-75" >' + nbre_ticket + 'x {{$type_ticket->nom_ticket}} :</span> <span class="p-2" id="total">' + total + '</div> <hr> <div class="col d-flex ms-3"><span class="fw-bold p-2 w-75">Frais :</span><span class="p-2">' + frais + '</span> </div><hr><div class="col d-flex ms-3"><span class="fw-bold p-2 w-75">total :</span><span class="p-2" id="netApayer">' + NaP + '</span></div>';
                                resumeDiv.innerHTML = resume;
                                document.querySelector('input[name="montant"]').setAttribute('value', total);
                                if ($('#format').val()=="Ticket") {
                                    submitButton=`<button type="submit" id="submitButton" 
                                                        data-transaction-amount="${total}"
                                                        data-transaction-description="${$("#submitButton").attr("data-transaction-description")}" 
                                                        data-customer-email="${$("#submitButton").attr("data-customer-email")}"
                                                        data-customer-lastname="${$("#submitButton").attr(" data-customer-lastname")}"
                                                        data-customer-firstname="${$("#submitButton").attr("data-customer-firstname")} "
                                                        data-customer-phone_number-number="${$("#submitButton").attr("data-customer-phone_number-number")}"
                                                        data-customer-phone_number-country='bj'
                                                        data-environment="sandbox"
                                                        data-type-ticket-id="${$("#submitButton").attr("data-type-ticket-id")}"
                                                        class="btn btn-success col-12">Obtenir
                                                    </button>`  
                                    $("#submitSpace").html(submitButton);
                                }
                                console.log(nbre_ticket);
                                
                            }
                            if(nbre_ticket == 0){
                                resumeDiv.innerHTML = "";
                                document.querySelector('input[name="montant"]').removeAttribute('value');
                                $("#submitButton").attr("disabled", true);
                            }
                            
                    }
                    function disableSubmitButton(form) {
                        form.querySelector('#submitButton').disabled = true;
                    }
                   
                </script>
                <script type="text/javascript">
                $("#submitSpace").on("click", "#submitButton", function () {
                    let btn = document.getElementById('submitButton');
                    let freeBtn=document.getElementById('FreeSubmitButton');
                    console.log(btn);
                    
                    if (btn) {
                        const amount = btn.getAttribute('data-transaction-amount');
                        const description = btn.getAttribute('data-transaction-description');
                        const customerEmail = btn.getAttribute('data-customer-email');
                        const customerFirstname = btn.getAttribute('data-customer-firstname');
                        const customerLastname = btn.getAttribute('data-customer-lastname');
                        const customerPhone = btn.getAttribute('data-customer-phone_number');
                        const currency = btn.getAttribute('data-currency');
                        const type_ticket_id= btn.getAttribute('data-type-ticket-id');

                        let widget =  FedaPay.init({
                            public_key: 'pk_sandbox_xbkhgDVudRXjQwp9t1u8o4rN',
                            transaction: {
                                amount: amount,
                                description:description
                            },
                            customer: {
                                firstname: customerFirstname,
                                lastname: customerLastname,
                                email: customerEmail,
                                phone_number: {
                                    number: customerPhone,
                                    country: 'bj' // Code pays, ou récupéré dynamiquement
                                }
                            },
                            onComplete:function (reason, transaction ){
        
                                if (reason.reason=='CHECKOUT COMPLETE') {
                                        
                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });

                                    $.ajax({
                                        type: 'POST',
                                        url: '/verifiedTransaction',
                                        data: {
                                            type_ticket_id:type_ticket_id,
                                            transaction_id:reason.transaction.id,
                                            nbr:nbr,
                                        },
                                        dataType: 'JSON',
                                        beforeSend:function(){
                                            $('#submitButton').html(`
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            `)
                                        },
                                        success:function(data){
                                            if (data.message) {
                                                $('.contentToSubmit').html(`
                                                    <form action="{{route('SendTicket')}}" method="POST" id="formToSubmit">
                                                        <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}" autocomplete="off">
                                                        <input type="hidden" name="transaction_id" value="${data.transaction_id}">
                                                        <input type="hidden" name="type_ticket_id" value="${data.type_ticket_id}">
                                                        <input type="hidden" name="nbr" value="${data.nbreTicket}">
                                                    </form>  
                                                `)

                                                $('#formToSubmit').submit();
                                            }else if(data.error){
                                               $('#AjaxMessage').html(`
                                                    <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
                                                        <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                                                            <div class="toast-body d-flex align-items-center">
                                                                <div class="p-2">
                                                                    <svg class="bi bi-x-circle" fill="#fff" width="30" height="30">
                                                                        <use xlink:href="#error"></use>
                                                                    </svg>
                                                                </div>
                                                                <div class="p-2 fw-bold fs-5">${data.error}</div>
                                                                <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>    
                                                `)
                                                const toastLiveExample = document.getElementById('liveToast');

                                                if (toastLiveExample) {
                                                    const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                                                    toastBootstrap.show();
                                                }
                                            }
                                            
                                        }
                                        
                                    });
            
                                }
                            
                            }
                            
                        });
                    
                        btn.addEventListener('click', () => {
                            nbr=$('#nombre_ticket').val();
                        
                            widget.open();
                        });
                    }
                    if (freeBtn) {
                        freeBtn.addEventListener('click', ()=>{
                            nbr=$('#nombre_ticket').val();
                            const type_ticket_id= freeBtn.getAttribute('data-type-ticket-id');

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: 'POST',
                                url: '/verifiedTransaction',
                                data: {
                                    type_ticket_id:type_ticket_id,
                                    nbr:nbr,
                                },
                                dataType: 'JSON',
                                beforeSend:function(){
                                    $('#FreeSubmitButton').html(`
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    `)
                                },
                                success:function(data){
                                    if (data.message) {
                                        $('.contentToSubmit').html(`
                                            <form action="{{route('SendTicket')}}" method="POST" id="formToSubmit">
                                                <input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}" autocomplete="off">
                                                <input type="hidden" name="transaction_id" value="${data.transaction_id}">
                                                <input type="hidden" name="type_ticket_id" value="${data.type_ticket_id}">
                                                <input type="hidden" name="nbr" value="${data.nbreTicket}">
                                            </form>  
                                        `)

                                        $('#formToSubmit').submit();
                                    }else if(data.error){
                                        $('#AjaxMessage').html(`
                                            <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
                                                <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                                                    <div class="toast-body d-flex align-items-center">
                                                        <div class="p-2">
                                                            <svg class="bi bi-x-circle" fill="#fff" width="30" height="30">
                                                                <use xlink:href="#error"></use>
                                                            </svg>
                                                        </div>
                                                        <div class="p-2 fw-bold fs-5">${data.error}</div>
                                                        <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                                    </div>
                                                </div>
                                            </div>    
                                        `)
                                        const toastLiveExample = document.getElementById('liveToast');

                                        if (toastLiveExample) {
                                            const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                                            toastBootstrap.show();
                                        }
                                    }
                                }
                                
                            });
        
                        })

                    }
                })
                    
                  
                    document.addEventListener('DOMContentLoaded', function () {
                        const toastLiveExample = document.getElementById('liveToast');

                        if (toastLiveExample) {
                            const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                            toastBootstrap.show();
                        }
                    });
                </script>
            </div>
           
        </div>
        
       
    @endsection