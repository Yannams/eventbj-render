@extends($layout)
    @section('content')
    
        <form action="{{route('getChartsData')}}" method="post" id="ChartsDataForms">
            @csrf
            <input type="hidden" name="evenement_id" value="{{$evenement->id}}">

        <div class="row  g-4 mb-5">
            <div class="col-12 col-md-8">
                <div class="card border-0">
                    <img src="{{asset($evenement->cover_event)}}" alt="cover-img" class="card-img" height="400px">
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card h-100 border-0">
                    <div class="card-body">
                        <div class="card-title fs-2 fw-bold">{{$evenement->nom_evenement}}</div>
                        <div class="fs-5 fw-medium mt-4">Date de début : {{date('d/m/Y', strtotime($evenement->date_heure_debut))}}</div>
                        <div class="fs-5 fw-medium mt-2">Date de fin : {{date('d/m/Y',strtotime($evenement->date_heure_fin))}}</div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="card-title fw-semibold">Statistique de vente des tickets</div>
                        <div>
                            <canvas id="TicketSold"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
               <div class="row g-3">
                    <div class="col-12">
                        <div class="card border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="card-title fw-semibold w-100">billets vendus cette semaine</div> 
                                    <select name="periode" id="periode" class="form-select rounded-4 flex-shrink-1">
                                             <option value="7">7 derniers jours</option>
                                            <option value="30">30 derniers jours</option>
                                            <option value="billeterie">toute la durée de la billetterie</option>
                                    </select>
                                </div>
                               
                               <div>
                                    <canvas id="WeeklySales"></canvas>
                               </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-6">
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
                    <div class="col-12 col-md-6">
                        <div class="card border-0 h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="card-title fw-semibold w-100">evolution du revenu</div> 
                                    <select name="periode_revenu" id="periode_revenu" class="form-select rounded-4 flex-shrink-1">
                                            <option value="7">7 derniers jours</option>
                                            <option value="30">30 derniers jours</option>
                                            <option value="billeterie">toute la durée de la billetterie</option>
                                    </select>
                                </div>
                               
                               <div>
                                    <canvas id="Revenu"></canvas>
                               </div> 
                            </div>
                        </div>
                    </div>
               </div>
            </div>
            <div class="col-12 col-md-4">
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
            <div class="col-12 col-md-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="card-title fw-semibold w-100">Nombre de click</div>
                            <select name="periode_click" id="periode_click" class="form-select rounded-4 flex-shrink-1">
                                    <option value="7">7 derniers jours</option>
                                    <option value="30">30 derniers jours</option>
                                    <option value="billeterie">toute la durée de la billetterie</option>
                            </select>
                        </div>
                        
                        <div>
                            <canvas id="click"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="card-title fw-semibold w-100">Nombre d'inscription</div>
                            <select name="periode_inscription" id="periode_inscription" class="form-select rounded-4 flex-shrink-1">
                                <option value="7">7 derniers jours</option>
                                <option value="30">30 derniers jours</option>
                                <option value="billeterie">toute la durée de la billetterie</option>
                            </select>
                        </div>
                        
                        <div>
                            <canvas id="inscription"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-tems-center ">
                            <div class="card-title fw-semibold w-100">Taux de conversion:</div>
                            <select name="periode_conversion" id="periode_conversion" class="form-select rounded-4 flex-shrink-1">
                                    <option value="7">7 derniers jours</option>
                                    <option value="30">30 derniers jours</option>
                                    <option value="billeterie">toute la durée de la billetterie</option>
                            </select>
                        </div>
                       
                        <div>
                            <canvas id="conversion"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        <input type="hidden" name="evenement_id" id="evenement_id" value="{{$evenement->id}}">
        <script>
            var dataform=document.getElementById('ChartsDataForms')
            var evenement_id_input=document.getElementById('evenement_id');
            var periode_input=document.getElementById('periode');
            var periode_revenu_input=document.getElementById('periode_revenu');
            var periode_click_input=document.getElementById('periode_click');
            var periode_inscription_input=document.getElementById('periode_inscription');
            var periode_conversion_input=document.getElementById('periode_conversion');

            var evenement_id=evenement_id_input.value;
            var periode=periode_input.options[document.getElementById('periode').selectedIndex].value;
            var periode_revenu=periode_revenu_input.value;
            var periode_click=periode_click_input.value;
            var periode_inscription=periode_inscription_input.value;
            var periode_conversion=periode_conversion_input.value;
          
            function GetData() {
                
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
                            periode: periode,
                            periode_revenu:periode_revenu,
                            periode_click:periode_click,
                            periode_inscription:periode_inscription,
                            periode_conversion:periode_conversion,
                      },

                      dataType:'JSON',
                
                    success: function(data){
                        TicketSold(data);
                        WeeklySales(data)
                        click(data);
                        inscription(data);
                        revenu(data);
                        conversion(data);
                    }
                  }
              )

                
            };

            
            $('#periode').change(function() {
                 periode = $(this).val();
                 GetData();
            });

            $('#periode_revenu').change(function() {
                 periode_revenu = $(this).val();
               GetData();
            }); 
            $('#periode_click').change(function() {
                 periode_click = $(this).val();
               GetData();
            });
            $('#periode_inscription').change(function() {
                 periode_inscription = $(this).val();
               GetData();
            });
            $('#periode_conversion').change(function() {
                 periode_conversion = $(this).val();
               GetData();
            });
           
            
            document.addEventListener('DOMContentLoaded',GetData() )
            
            function TicketSold(data) {
                const ctx = document.getElementById('TicketSold');
                TicketSoldChart=Chart.getChart("TicketSold");
               if(TicketSoldChart !== undefined){
                TicketSoldChart.destroy()
               }
                TicketSoldChart= new Chart(ctx,{
                    type: 'doughnut',
                    data:{
                        labels: data.type_ticket,
                        datasets:[{
                            label:'Nombre de ticket vendus',
                            data:data.nombreTicketParTypeticket,
                            backgroundColor:[
                                '#308747',
                                '#FBAA0A',
                                '#F0343C',
                                
                            ],
                        hoverOffset: 4
                        }],
                        
                    }
                });
              
            }

            function WeeklySales(data) {
                let WeeklySalesChart=Chart.getChart('WeeklySales');
                if (WeeklySalesChart!= undefined) {
                    WeeklySalesChart.destroy()
                }

               WeeklySalesChart = new Chart(
                document.getElementById("WeeklySales"),
                {
                    type: "line",
                    data: {
                    labels: data.dates,
                    datasets: data.datasells
                    },
                    options: {
                    // Options du graphique
                    },
                }
                );

            }
            function click(data) {
                let clickChart = Chart.getChart('click');
                if (clickChart != undefined) {
                    clickChart.destroy()
                }
                clickChart= new Chart(
                document.getElementById("click"),
                {
                    type: "line",
                    data: {
                    labels: data.date_click,
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
                let  IncriptionChart = Chart.getChart('inscription');
                if ( IncriptionChart != undefined) {
                     IncriptionChart.destroy()
                }
                IncriptionChart = new Chart(
                document.getElementById("inscription"),
                {
                    type: "line",
                    data: {
                    labels: data.date_inscription,
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
                let  revenuChart = Chart.getChart('Revenu');
                if ( revenuChart != undefined) {
                     revenuChart.destroy()
                }
                revenuChart= new Chart(
                document.getElementById("Revenu"),
                {
                    type: "line",
                    data: {
                    labels: data.date_revenu,
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
            function conversion(data) {
                let  ConversionChart = Chart.getChart('conversion');
                if ( ConversionChart != undefined) {
                     ConversionChart.destroy()
                }
                ConversionChart = new Chart(
                document.getElementById("conversion"),
                {
                    type: "line",
                    data: {
                    labels: data.date_conversion,
                    datasets: 
                        [{
                            label: "Taux de conversion",
                            data: data.taux_conversion,
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