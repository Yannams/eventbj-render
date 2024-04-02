@extends('layout.promoteur')
    @section('content')
        {{-- <form action="{{route('getChartsData')}}" method="post">
            @csrf
            <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
            <button type="submit">Button</button>
        </form> --}}

        <div class="row g-4">
            <div class="col-8">
                <div class="card border-0">
                    <img src="{{asset($evenement->cover_event)}}" alt="cover-img" class="card-img" height="400px">
                </div>
            </div>
            <div class="col-4">
                <div class="card h-100 border-0">
                    <div class="card-body">
                        <div class="card-title fs-2 fw-bold">{{$evenement->nom_evenement}}</div>
                        <div class="fs-5 fw-medium mt-4">Date de début : {{date('d/m/Y', strtotime($evenement->date_heure_debut))}}</div>
                        <div class="fs-5 fw-medium mt-2">Date de fin : {{date('d/m/Y',strtotime($evenement->date_heure_fin))}}</div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="card-title fw-semibold">Statistique de vente des tickets</div>
                        <div>
                            <canvas id="TicketSold"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
               <div class="row g-3">
                    <div class="col-12">
                        <div class="card border-0">
                            <div class="card-body">
                               <div class="card-title fw-semibold">billets vendus cette semaine</div>
                               <div>
                                    <canvas id="WeeklySales"></canvas>
                               </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="card border-0 h-100">
                            <div class="card-body">
                                @php
                                    $nbrTotalTickets=0;
                                    $revenu_total=0;
                                    foreach ($evenement->type_tickets as $type_ticket) {
                                       $revenu=$type_ticket->tickets->count()*$type_ticket->prix_ticket;
                                       $revenu_total=$revenu_total+$revenu;
                                       $nbrTickets=$type_ticket->tickets->count();
                                       $nbrTotalTickets=$nbrTotalTickets+$nbrTickets;
                                    }
                                    $x=0
                                @endphp
                                   <div class="card-title fw-semibold">Revenu total:  <i class="bi bi-coin" style="color: #FBAA0A"></i> {{$revenu_total}} </div> 
                                   <div class="card-text">
                                        @foreach ($evenement->type_tickets as $type_ticket )

                                            <div class="d-flex align-items-center">
                                                <span>
                                                    
                                                    <i class="bi bi-dot fs-1" style="color:{{$Color_tab[$x]}}"></i>
                                                </span> 
                                                <span class="fw-semibold">{{$type_ticket->nom_ticket}}:</span>
                                                <span class="ms-5"><span><i class="bi bi-coin" style="color: #FBAA0A"></i></span>   {{$type_ticket->tickets->count()*$type_ticket->prix_ticket}}</span>
                                            </div>
                                            @php
                                                $x++
                                            @endphp
                                        @endforeach
                                   </div>
                                   
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 h-100">
                            <div class="card-body">
                               <div class="card-title fw-semibold">evolution du revenu</div> 
                               <div>
                                    <canvas id="Revenu"></canvas>
                               </div> 
                            </div>
                        </div>
                    </div>
               </div>
            </div>
            <div class="col-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="card-title fw-semibold">Taux d'intérêt</div>
                        <div>
                            @php
                                $nombreClickTotal=0;
                                foreach ($evenement->users as $pivot_table) {
                                  $nombreClick= $pivot_table->pivot->nombre_click;
                                  $nombreClickTotal+=$nombreClick;
                                }
                            @endphp
                            <div><i class="bi bi-cursor-fill fs-5" style="color: #308747"></i> <span class="fw-semibold">Nombre de click :</span> {{$nombreClickTotal}} </div>
                            <div><i class="bi bi-person-fill-add fs-5" style="color: #FBAA0A"></i> <span class="fw-semibold">Nombre d'incrit :</span> {{$nbrTotalTickets}}</div>
                            <div><i class="bi bi-heart-fill fs-5 " style="color: #F0343C"></i> <span class="fw-semibold">Nombre de like :</span> @if ($evenement->users()->get()->isEmpty()) 0 @else {{$evenement->users()->wherePivot('like',true)->count()}} @endif</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="card-title fw-semibold">Nombre de click</div>
                        <div>
                            <canvas id="click"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="card-title fw-semibold">Nombre d'inscription</div>
                        <div>
                            <canvas id="inscription"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="card-title fw-semibold">Taux de conversion:</div>
                        <div>
                            <canvas id="conversion"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="evenement_id" id="evenement_id" value="{{$evenement->id}}">
        <script>
            evenement_id_input=document.getElementById('evenement_id');
            evenement_id=evenement_id_input.value
            document.addEventListener('DOMContentLoaded', function GetData() {
                $.ajaxSetup(
                  {
                      headers:{
                          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      }
                  }
              )
                $.ajax(
                  {
                      type:'POST',
                      url: '/getChartsData',
                      data:{
                          evenement_id:evenement_id,
                      },

                      dataType:'JSON',
                
                    success: function(data){
                        
                        TicketSold(data);
                        WeeklySales(data)
                        click(data);
                        inscription(data);
                        revenu(data);
                        conersion(data);
                    }
                  }
              )

                
            })
            function TicketSold(data) {
                const ctx = document.getElementById('TicketSold');

                new Chart(ctx,{
                    type: 'doughnut',
                    data:{
                        labels: data.type_ticket,
                        datasets:[{
                            label:'Nombre de ticket vendus',
                            data:data.nombreTicket,
                            backgroundColor:[
                                '#308747',
                                '#FBAA0A',
                                '#F0343C'
                            ],
                        hoverOffset: 4
                        }],
                        
                    }
                })
            }

            function WeeklySales(data) {
                const WeeklySales = new Chart(
                document.getElementById("WeeklySales"),
                {
                    type: "line",
                    data: {
                    labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi","Dimanche"],
                    datasets: data.datasells
                    },
                    options: {
                    // Options du graphique
                    },
                }
                );

            }
            function click(data) {
                const WeeklySales = new Chart(
                document.getElementById("click"),
                {
                    type: "line",
                    data: {
                    labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi","Dimanche"],
                    datasets: 
                        [{
                            label: "Nombre de click",
                            data: data.evolution_click,
                            borderColor:"#FBAA0A",
                        }]
                    },
                    options: {
                        tension: 0.4
                    },
                }
                );
            }

            function inscription(data) {
                const WeeklySales = new Chart(
                document.getElementById("inscription"),
                {
                    type: "line",
                    data: {
                    labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi","Dimanche"],
                    datasets: 
                        [{
                            label: "nombre d'incription",
                            data: data.evolution_inscription,
                            borderColor:"#F0343C",
                        }]
                    },
                    options: {
                        tension: 0.4
                    },
                }
                );
            }
            
            function revenu(data) {
                const WeeklySales = new Chart(
                document.getElementById("Revenu"),
                {
                    type: "line",
                    data: {
                    labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi","Dimanche"],
                    datasets: 
                        [{
                            label: "evolution_revenu",
                            data: data.evolution_revenu,
                            borderColor:"#308747",
                        }]
                    },
                    options: {
                        tension: 0.4
                    },
                }
                );
            }
            function conersion(data) {
                const WeeklySales = new Chart(
                document.getElementById("conversion"),
                {
                    type: "line",
                    data: {
                    labels: ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi","Dimanche"],
                    datasets: 
                        [{
                            label: "Taux de conversion",
                            data: data.ConversionPerDay,
                            borderColor:"#308747",
                        }]
                    },
                    options: {
                        
                    },
                }
                );
            }
            
            
        </script>
    @endsection