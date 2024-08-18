@extends('layout.Admin')
    @section('content')
        <div class="row row-cols-1 g-3">
            <div class="col-md-8 col-lg-8 col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center" >
                            <span class="flex-grow-1 fw-bold">Utilisateurs</span>
                            <div class=""> 
                                <select name="user_periode" id="user_periode" class="form-select rounded-3">
                                    <option value="7" >7 jours</option>
                                    <option value="14"> 14 jours</option>
                                    <option value="30">30 jours</option>
                                    <option value="90">90 jours</option>
                                    <option value="90">1 an</option>
                                    <option value="">Depuis le lancemant</option>
                                </select>
                            </div>
                            
                        </div>
                       <div>
                            <canvas id="utilisateurs"></canvas>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="fw-bold ">Total : <span id="Total_user"></span></div>
                        <div class="h-100 d-flex justify-content-center flex-column">
                            <div class="row mb-4">
                                <div class="col-1">
                                    <div style="width: 20px;height: 20px;background:#308747;" class=""></div>
                                </div>
                                <div class="col-6">
                                    <div class="me-4 fw-semibold  ">Inscription :</div>   
                                </div>
                                <div class="col">
                                    <div style="color: #308747" id="RegisterValueThisDay" class="fw-semibold fs-5"></div>
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-1">
                                    <div style="width: 20px;height: 20px;background:#F0343C;" class="me-1"></div>
                                </div>
                                <div class="col-6">
                                    <div class="me-4 fw-semibold">Desinscription :</div>
                                </div>
                                <div class="col">
                                    <div style="color: #F0343C" id="DisregisterValueThisDay" class="fw-semibold fs-5"></div>
                                   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-1">
                                    <div style="width: 20px;height: 20px;background:#FBAA0A;" class="me-1"></div>
                                </div>
                                <div class="col-6">
                                    <div class="me-4 fw-semibold">Total :</div>   
                                </div>
                                <div class="col">                                    
                                    <div style="color: #FBAA0A" id="totalValueThisDay" class="fw-semibold fs-5"></div>                                    
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-12">
                                <canvas id="UserSegmentation"></canvas>
                            </div>
                            <div class="col-md-8 col-lg-8 col-12">
                                <div class="h-100 d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#308747;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> utilisateur ayant clique sans acheter </div> </div>
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#FBAA0A;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> utilisateurs ayant achete des tickets pour un seul evenement </div></div>
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#F0343C;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> utilisateurs ayant achete des tickets pour plusieurs evenement </div></div>
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#D4D9E5;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> utilisateur n’ayant effectue aucune action sur la plateforme </div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-lg-4 col-12">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center" >
                            <span class="flex-grow-1 fw-bold">Promoteurs</span>
                            <div class=""> 
                                <select name="promoteur_periode" id="promoteur_periode" class="form-select rounded-3">
                                    <option value="7" >7 jours</option>
                                    <option value="14"> 14 jours</option>
                                    <option value="30">30 jours</option>
                                    <option value="90">90 jours</option>
                                    <option value="90">1 an</option>
                                    <option value="">Depuis le lancemant</option>
                                </select>
                            </div>
                        </div>
                        <canvas id="new_promoteur"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-8 col-12">
                <div class="card border-0  h-100">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-12">
                                <div class="h-100 d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#308747;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> Promoteur avec plusieurs evenement </div> </div>
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#FBAA0A;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> Promoteur avec un seul evenement </div></div>
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#F0343C;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> Promoteur avec aucun evenement </div></div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-12">
                                <canvas id="PromoteurSegmentation"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-12">
                                <canvas id="evenementSegmentation"></canvas>
                            </div>
                            <div class="col-md-8 col-lg-8 col-12">
                                <div class="h-100 d-flex justify-content-center flex-column">
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#308747;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> evenement ayant vendu tous les tickets </div> </div>
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#FBAA0A;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> evenement ayant vendu  au moins la moitie de ses tickets </div></div>
                                    <div class="d-flex align-items-center"> <div class="" style="background-color:#F0343C;width:20px;height:20px;"></div> <div class="fw-semibold fs-5 ms-2"> evenement ayant vendu moins de la moitie de ses tickets </div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-12">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center" >
                            <span class="flex-grow-1 fw-bold">Taux de rebond</span>
                            <div class=""> 
                                <select name="promoteur_periode" id="promoteur_periode" class="form-select rounded-3">
                                    <option value="7" >7 jours</option>
                                    <option value="14"> 14 jours</option>
                                    <option value="30">30 jours</option>
                                    <option value="90">90 jours</option>
                                    <option value="90">1 an</option>
                                    <option value="">Depuis le lancemant</option>
                                </select>
                            </div>
                        </div>
                        <Canvas id="TauxRebond"></Canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-12">
                <div class="card border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center" >
                            <span class="flex-grow-1 fw-bold">Taux de retention</span>
                            <div class=""> 
                                <select name="promoteur_periode" id="promoteur_periode" class="form-select rounded-3">
                                    <option value="7" >7 jours</option>
                                    <option value="14"> 14 jours</option>
                                    <option value="30">30 jours</option>
                                    <option value="90">90 jours</option>
                                    <option value="90">1 an</option>
                                    <option value="">Depuis le lancemant</option>
                                </select>
                            </div>
                        </div>
                        <canvas id="TauxRetention"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <script>
            var user_periode=document.getElementById('user_periode').value;
            var promoteur_periode=document.getElementById('promoteur_periode').value;
    
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
                      url: '/getChartsDataAdmin',
                      data:{
                            user_periode:user_periode,
                            promoteur_periode:promoteur_periode,
                      },

                      dataType:'JSON',
                
                    success: function(data){
                        user_evolution(data);
                        UserSegmentation(data);
                        promoteur_evolution(data);
                        PromoteurSegmentation(data);
                        evenementSegmentation(data);
                        evolutionPerDay(data)
                    }
                  }
              )

                
            };

            
            $('#user_periode').change(function() {
                 periode = $(this).val();
            GetData();
            });

            $('#promoteur_periode').change(function() {
                 periode = $(this).val();
            GetData();
            });

           
            
            document.addEventListener('DOMContentLoaded',GetData())
            
           
            function user_evolution(data) {
                let utilisateursChart = Chart.getChart('utilisateurs');
                if ( utilisateursChart != undefined) {
                     utilisateursChart.destroy()
                }
                utilisateursChart = new Chart(
                document.getElementById("utilisateurs"),
                {
                    type: "line",
                    data: {
                    labels: data.DatesInscription ,
                    datasets: 
                    [
                        {
                            label: "inscription",
                            data: data.NbreInscriptionPerDay,
                            borderColor:"#308747",
                        },
                        {
                            label: "desinscription",
                            data: data.NbreDesinscriptionPerDay,
                            borderColor:"#F0343C",
                        },
                        {
                            label: "Total",
                            data: data.NbreTotalPerDay,
                            borderColor:"#FBAA0A",
                        },
                        
                    ]
                    },
                    options: {
                        tension: 0.5
                    },
                }
                );
            }
            function UserSegmentation(data) {
                const ctx = document.getElementById('UserSegmentation');
                UserSegmentationChart=Chart.getChart("UserSegmentation");
               if(UserSegmentationChart !== undefined){
                UserSegmentationChart.destroy()
               }
                UserSegmentationChart= new Chart(ctx,{
                    type: 'doughnut',
                    data:{
                        labels: ['cliqueurs','acheteur unique','multi-acheteurs','fantomes'],
                        datasets:[{
                            label:'Nombre segment',
                            data:data.user_segmentation,
                            backgroundColor:[
                                '#308747',
                                '#FBAA0A',
                                '#F0343C',
                                '#D4D9E5'
                            ],
                        hoverOffset: 4
                        }],
                        
                    }
                });
              
            }

            function promoteur_evolution(data) {
                let new_promoteurChart = Chart.getChart('new_promoteur');
                if ( new_promoteurChart != undefined) {
                     new_promoteurChart.destroy()
                }
                new_promoteurChart = new Chart(
                document.getElementById("new_promoteur"),
                {
                    type: "line",
                    data: {
                    labels: data.DatePromoteurs ,
                    datasets: 
                    [
                        {
                            label: "inscription",
                            data: data.NbrePromoteursPerDay,
                            borderColor:"#FBAA0A",
                        },    
                    ]
                    },
                    options: {
                        tension: 0.5
                    },
                }
                );
            }
            function PromoteurSegmentation(data) {
                const ctx = document.getElementById('PromoteurSegmentation');
                PromoteurSegmentationChart=Chart.getChart("PromoteurSegmentation");
               if(PromoteurSegmentationChart !== undefined){
                PromoteurSegmentationChart.destroy()
               }
                PromoteurSegmentationChart= new Chart(ctx,{
                    type: 'doughnut',
                    data:{
                        labels: ['promoteur multiple','promoteur unique','promoteur fantomes'],
                        datasets:[{
                            label:'Nombre segment',
                            data:data.promoteur_segmentation,
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
            function evenementSegmentation(data) {
                const ctx = document.getElementById('evenementSegmentation');
                evenementSegmentationChart=Chart.getChart("evenementSegmentation");
               if(evenementSegmentationChart !== undefined){
                evenementSegmentationChart.destroy()
               }
                evenementSegmentationChart= new Chart(ctx,{
                    type: 'doughnut',
                    data:{
                        labels: ['sold out','plus de 50% vendus ',' moins de 50% vendu'],
                        datasets:[{
                            label:'Nombre segment',
                            data:data.evenement_segmentation,
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

            function evolutionPerDay(data) {
                $('#totalValueThisDay').html('='+data.NbreTotalPerDay[7]);
                $('#DisregisterValueThisDay').html('-'+data.NbreDesinscriptionPerDay[7]);
                $('#RegisterValueThisDay').html('+'+data.NbreInscriptionPerDay[7]);
                $('#Total_user').html(data.total_user)
            }
        </script>
    @endsection