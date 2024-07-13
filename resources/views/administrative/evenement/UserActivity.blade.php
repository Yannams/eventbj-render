@extends('layout.Admin')
    @section('content')
    <div class="container">
        <div class="position-relative">
            <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
               
            </div>    
        </div>
        <div class="row">
            <div class="col-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="fs-4">Evènements Consultés</div>
                        <div class="" style="font-size: 60px">{{$user->evenements()->count()}}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="fs-4">Ticket acheté</div>
                        <div class="" style="font-size: 60px">{{$user->tickets()->count()}}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="fs-4">Evènements favoris</div>
                        <div class="" style="font-size: 60px">{{$user->evenements()->wherePivot('like','1')->count()}}</div>
                    </div>
                </div>
            </div>
            
            <div class="col-6 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="fs-4">Evènements participés</div>
                        <div class="" style="font-size: 60px">{{$user->tickets()->where('statut','vérifié')->count()}}</div>
                    </div>
                </div> 
            </div>
           <div class="col-12 mb-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="card-title fs-4">Evènements organisés :<span>{{$user->Profil_promoteur->evenements->count()}}</span></div>
                        <table class="table align-middle">
                            <thead>
                              <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nom </th>
                                <th scope="col">statut </th>
                                <th scope="col">statut administrative </th>
                                <th scope="col">recommandé</th>
                                <th scope="col">Créé le</th>
                                <th scope="col">Options</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->Profil_promoteur->evenements as $evenement )
                                    <tr>
                                        <th scope="row">
                                            <img src="{{asset($evenement->cover_event)}}" alt="" width="100px" class="rounded-3">
                                        </th>
                                        <td>{{$evenement->nom_evenement}}</td>
                                        <td class="OnlineStatus">@if ( $evenement->isOnline==false )
                                          non-publié
                                        @else
                                          en ligne
                                        @endif</td>
                                        <td class="administrative_status">@if ($evenement->administrative_status==false)
                                          désactivé administrativemenent
                                        @else
                                          activé administrativemenent
                                        @endif</td>
                                        <td class="Recommand_status">@if ($evenement->recommanded==false)
                                            non
                                          @else
                                            oui
                                          @endif</td>
                                        <td>{{date('d/m/Y à h:i', strtotime($evenement->created_at))}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <a class="btn btn-secondary" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </a>
                                              
                                                <ul class="dropdown-menu">
                                                  <li><a class="dropdown-item" href="{{route('evenement.show',$evenement->id)}}">Voir plus</a></li>
                                                  <li><a class="dropdown-item" href="{{route('gererEvent',$evenement->id)}}">Voir les performances </a></li>
                                                  <li><button class="dropdown-item sendEvent" data-evenement-id="{{$evenement->id}}">@if ($evenement->administrative_status==true)
                                                    Désactiver l'évènement
                                                  @else
                                                    Activer l'évènement
                                                  @endif </button></li>
                                                  <li><button class="dropdown-item recommand" data-evenement-id="{{$evenement->id}}">@if ($evenement->recommanded==true)
                                                    Retirer des recommandations
                                                  @else
                                                    Recommander l'évènement
                                                  @endif </button></li>
                                                </ul>
                                              </div>
                                        </td>
                                    </tr>   
                                @endforeach
                              
                             
                            </tbody>
                          </table>
                    </div>
                </div>
           </div>
        </div>
        <script>
            var SendEventbtn=document.querySelectorAll('.sendEvent');
            var liveToast=document.querySelector('.toast-container')
            var administrative_status=document.querySelectorAll('.administrative_status');
            var Recommand_status=document.querySelectorAll('.Recommand_status');
            var OnlineStatus=document.querySelectorAll('.OnlineStatus')
            SendEventbtn.forEach(function (sendEvent,index) {
               sendEvent.addEventListener('click', function SendEventAction(event) {
                    event.preventDefault();
                    evenement_id=sendEvent.getAttribute('data-evenement-id');
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
                            url: '/Administrative_activation',
                            data:{
                                evenement_id: evenement_id,
                            },
    
                            dataType:'JSON',
    
                            success: function(data) {
                                if (data.success==true) {
                                    if (data.status==true) {
                                        sendEvent.innerHTML="Désactiver l'évènement"
                                        administrative_status[index].innerHTML="activé administrativement "
                                    }else{
                                        sendEvent.innerHTML="Activer l'évènement"
                                        administrative_status[index].innerHTML="désactivé administrativement"
                                        Recommand_status[index].innerHTML="non"
                                        OnlineStatus[index].innerHTML="non-publié"
                                    }
                                   
                                    liveToast.innerHTML=' <div id="liveToast" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"> <div class="toast-body d-flex align-items-center"><div class="p-2"><svg class="bi bi-check-all" fill="#fff" width="30" height="30"><use xlink:href="#check"></use></svg></div><div class="p-2 fw-bold fs-5">'+data.message+'</div><button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>'
                                    const toastLiveExample = document.getElementById('liveToast');
    
                                    if (toastLiveExample) {
                                        const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                                        toastBootstrap.show();
                                    }
                                }else if(data.redirect==true){
                                    window.location.href = data.redirecturl;
                                }
                            }
                        }
                    )
                })
                })
    </script>
    <script>
        var RecommandEventbtn=document.querySelectorAll('.recommand');
        var liveToast=document.querySelector('.toast-container')
        var Recommand_status=document.querySelectorAll('.Recommand_status')
        console.log(Recommand_status);
        RecommandEventbtn.forEach(function ( RecommandEvent, index) {
            RecommandEvent.addEventListener('click', function RecommandEventAction(event) {
                event.preventDefault();
                evenement_id=RecommandEvent.getAttribute('data-evenement-id');
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
                        url: '/Recommand_Event',
                        data:{
                            evenement_id: evenement_id,
                        },
    
                        dataType:'JSON',
    
                        success: function(data) {
                            if (data.success==true) {
                                if (data.status==true) {
                                    RecommandEvent.innerHTML="Retirer des recommandations"
                                    Recommand_status[index].innerHTML="oui"
                                }else{
                                    RecommandEvent.innerHTML="Recommander l'évènement"
                                    Recommand_status[index].innerHTML="non"
                                }
                               
                                liveToast.innerHTML=' <div id="liveToast" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"> <div class="toast-body d-flex align-items-center"><div class="p-2"><svg class="bi bi-check-all" fill="#fff" width="30" height="30"><use xlink:href="#check"></use></svg></div><div class="p-2 fw-bold fs-5">'+data.message+'</div><button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>'
                                const toastLiveExample = document.getElementById('liveToast');
    
                                if (toastLiveExample) {
                                    const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                                    toastBootstrap.show();
                                }
                            }else if(data.redirect==true){
                                window.location.href = data.redirecturl;
                            }else if (data.success==false) {
                            liveToast.innerHTML=' <div id="liveToast" class="toast text-bg-success" role="alert" aria-live="assertive" aria-atomic="true"> <div class="toast-body d-flex align-items-center"><div class="p-2"><svg class="bi bi-check-all" fill="#fff" width="30" height="30"><use xlink:href="#check"></use></svg></div><div class="p-2 fw-bold fs-5">'+data.message+'</div><button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>'
                            const toastLiveExample = document.getElementById('liveToast');

                            if (toastLiveExample) {
                                const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                                toastBootstrap.show();
                            }
                        }
                        }
                    }
                )
            })
            })
    </script>
    
     
    @endsection