@extends('layout.promoteur')
    @section('content')
        <div class="container">
            <div class="position-relative">
                <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
                   
                </div>    
            </div>
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
             @endif
            <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom évènement</th>
                    <th scope="col">Statut </th>
                    <th scope="col">Date et heure début</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                @foreach ($evenement as $evenements )
                <tr class="">
                    
                    <th scope="row"><img src="{{asset($evenements->cover_event)}}" alt="cover" width="100" class="rounded"></th>
                    <td>{{$evenements->nom_evenement}}</td>
                    <td class="OnlineStatus">@if ( $evenements->administrative_status ==false)
                      Votre évènement a été désactivé par EventBJ. <br> Veuillez contacter le support de <a href="mailto:eventbj86@gmail.fr">EventBJ</a> pour régler le problème
                    @elseif ($evenements->isOnline ==false && $evenements->administrative_status ==true)
                        non-publié
                    @elseif ($evenements->isOnline ==true && $evenements->administrative_status ==true)
                        en ligne
                    @endif</td>
                    <td>{{date('d/m/Y à h:i', strtotime($evenements->date_heure_debut))}}</td>
                    <td>
                    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-2">
                        <div class="col">
                            {{-- <form action="{{route('OnlineEvents')}}" method="post">
                                @csrf
                                <input type="hidden" name="evenement_id" value="{{$evenements->id}}"> --}}
                                <button type="submit" class="btn btn-success sendEvent" @if($evenements->administrative_status ==false) disabled @endif data-evenement-id="{{$evenements->id}}">@if ($evenements->isOnline == 0) Mettre en ligne @else Désactiver l'évènement @endif </button>
                            {{-- </form> --}}
                        </div>
                        <div class="col">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success " data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                  <li>
                                    <a href="{{route('gererEvent',$evenements->id)}}" class=" dropdown-item">gérer</a>
                                </li>
                                  <li><a href="" class="dropdown-item">Modifier l'évènement</a></li>
                                  <li> 
                                    <form action="{{ route('evenement.destroy', $evenements) }}" method="POST" style="display: inline;" id="supprimer-etudiant-{{ $evenements->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">Supprimer</button>
                                    </form>
                                </li>
                                <li>
                                    <a href="{{route('PromoteurShow', $evenements)}}" class="dropdown-item"> voir</a>
                                </li>
                                <li>
                                    <a href="{{route('chronogramme.create',['event'=>$evenements->id])}}" class="dropdown-item"> Ajouter un chronogramme</a>
                                </li>
                                <li>
                                    <a href="{{route('Intervenant.index',['event'=>$evenements->id])}}" class="dropdown-item"> Ajouter un intervenant</a>
                                </li>
                                <li>
                                    <a href="" class="dropdown-item"> Ajouter un nouveau ticket </a>
                                </li>
                                </ul>
                              </div>
                        </div>
                    </div>
                     
                      
                    </td>

                  </tr> 
                @endforeach
                 
                </tbody>
              </table>
        </div>
        <script>
            var SendEventbtn=document.querySelectorAll('.sendEvent');
            var liveToast=document.querySelector('.toast-container')
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
                            url: 'onLine',
                            data:{
                                evenement_id: evenement_id,
                            },

                            dataType:'JSON',

                            success: function(data) {
                                if (data.success==true) {
                                    if (data.status==true) {
                                        sendEvent.innerHTML="désactiver l'évènement"
                                        OnlineStatus[index].innerHTML="en ligne"
                                    }else{
                                        sendEvent.innerHTML="Mettre en ligne"
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
        document.addEventListener('DOMContentLoaded', function () {
            const toastLiveExample = document.getElementById('liveToast');
            if (toastLiveExample) {
                const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                toastBootstrap.show();
            }
        });
    </script>  
    @endsection