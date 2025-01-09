@extends('layout.utilisateur')
    @section('content')
    @if (session('probleme'))
        {{session('probleme')}}    
    @else  
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
    @php
        $debut=0;
        $fin=4;
    @endphp
    <div class="border-0 rounded-4">
        <div class="">
            
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="d-flex">
                    <h1 class="p-2 flex-grow-1 fw-bold">A la une</h1>
                    <div class="p-2 me-2 d-none d-lg-inline">
                        <button class="button-carrousel p-2" id="prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="" aria-hidden="true"><svg class="bi bi-caret-right-fill" fill="currentColor" width="32" height="32"><use xlink:href="#previous-button"></use></svg> </span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        
                        <button class="button-carrousel p-2" id="next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="" aria-hidden="true"><svg class="bi bi-caret-right-fill" fill="currentColor" width="32" height="32"><use xlink:href="#next-button"></use></svg> </span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div id="responsiveCarousel" class="row flex-nowrap scrolling-wrapper "> </div>
               
                <div class="carousel-inner">
                   
                    @for($i=0; $i<$recommanded_events->count()/4; $i++)
                        <div class="carousel-item">
                            <div class="row row-cols-1 row-cols-md-4 g-3 mb-4 scrolling-wrapper recommended flex-nowrap">
                                @for ($j=$debut; $j<$fin; $j++)
                                @php
                                    if ($j>$recommanded_events->count()-1) {
                                        break;
                                    }
                                @endphp
                                    <div class="col recommandedEvent ">
                                        <div class="card low-padding rounded-4 border-0 card-size recommandedEventCard">
                                            <img src="{{asset($recommanded_events[$j]->cover_recommanded)}}"  class="img-recommanded card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                            <div class="card-body">
                                                <h5 class="card-title fw-bold">{{$recommanded_events[$j]->nom_evenement}}</h5>
                                                <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> {{date('d/m/Y',strtotime($recommanded_events[$j]->date_heure_debut))}}</p>
                                                <div class="text-end">
                                                    <a href="{{route('evenement.show',$recommanded_events[$j]->id)}}" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                 @endfor
                            </div>
                        </div>
                        @php
                            $debut+=4;
                            $fin+=4;
                        @endphp
                    @endfor   

                </div>
                
            </div>
        </div>
    </div>
       
   
  
    <div class="menu-container">
        <ul class="menu" >
            <li class="">
                <a href="{{ route('evenement.index') }}" class="@if (request()->url() == route('evenement.index') || request()->url() == route('home') ||request()->url() == route('index') ) active-link @else non-active @endif">
                   Pour vous
                </a>      
            </li>
            @foreach ( $Interests as $key => $Interest )
                <li class="">
                    <a href="{{ route('filteredByInterest', ['interest' => $Interest->id]) }}" class="@if (request()->url() == route('filteredByInterest', ['interest' => $Interest->id])) active-link @else non-active @endif ">
                        {{ $Interest->nom_ci }}
                    </a>  
                </li>
            @endforeach
            @if (auth()->check())
                <li class="">
                    <a href="{{ route('autres') }}" class="@if (request()->url() == route('autres')) active-link @else non-active @endif">
                        Autres
                    </a>
                </li> 
            @endif  
        </ul>
    </div>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 align-items-stretch g-4 py-4">
        @foreach ( $evenement as $evenements )
        <a href="{{route('evenement.show', ['evenement'=>$evenements->id])}}" class="clicked-link link-dark  link-offset-2 link-underline link-underline-opacity-0">
            <div class="col">
                <div class="card shadow card-cover overflow-hidden text-bg-dark rounded-4 shadow-lg border-0 evenement shadow p-2" style="background-image: url('{{asset($evenements->cover_event)}}'); background-size: cover;"> 
                   
                        <div class="badge tools-event pb-5 mb-5 rounded-3 card-header"> <span class="fs-3">{{date('d', strtotime($evenements->date_heure_debut))}}</span> <br> <span class="fs-6">{{date('M', strtotime($evenements->date_heure_debut))}}</span> </div>
                        <input type="hidden" id="event_id" name="evenement_id" value="{{$evenements->id}}">
                        <div class="d-flex mt-5 pt-4">
                            <div class="fw-bold fs-4 p-2 w-100 ">{{$evenements->nom_evenement}} </div>
                            <div  class="badge tools-event p-2 d-flex align-items-center justify-content-center flex-shrink-1 rounded-3 "> 
                                {{-- <form action="{{route('like_event')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="evenement_id" value="{{$evenements->id}}"> --}}
                                    @auth
                                        <button class="btn border-0 btn-like" data-event-id="{{$evenements->id}}" id="like">
                                            <svg class="bi bi-heart @if (Auth::user()->evenements()->find($evenements->id)!=null) @if (Auth::user()->evenements()->find($evenements->id)->pivot->like==1) d-none @endif @endif" data-event-id="{{$evenements->id}}" id="unliked" fill="currentColor" width="30" height="30" ><use xlink:href="#heart"></use></svg>
                                            <svg class="bi bi-heart-fill @if (Auth::user()->evenements()->find($evenements->id)!=null) @if (Auth::user()->evenements()->find($evenements->id)->pivot->like==0) d-none @endif @else d-none @endif" data-event-id="{{$evenements->id}}" id="liked" fill="red" width="30" height="30" ><use xlink:href="#heart-fill"></use></svg>
                                        </button>
                                    @else
                                        <form action="{{route('login')}}">
                                            <button class="btn">
                                                <svg class="bi bi-heart" fill="currentColor" width="30" height="30" ><use xlink:href="#heart"></use></svg>
                                            </button>
                                        </form>
                                    @endauth
                                {{-- </form>--}}
                            </div>
                        </div>
                   

                </div>
                
            </div>
        </a>
        
        @endforeach
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Récupérer les images
            var imges = document.querySelectorAll('.img-recommanded');
            console.log(imges);
            var containers = document.querySelectorAll('.recommandedEventCard');
            

            for (let i = 0; i < imges.length; i++) {
                (function(i) {
                    var img = imges[i];
                    var container = containers[i];

                    img.onload = function() {
                        console.log(img);
                        // Utiliser ColorThief pour extraire la couleur dominante
                        var colorThief = new ColorThief();
                        var dominantColor = colorThief.getColor(img);

                        var rgbColor = `rgb(${dominantColor[0]}, ${dominantColor[1]}, ${dominantColor[2]})`;
                       
                        // Appliquer la couleur dominante comme arrière-plan du conteneur
                        container.style.backgroundColor = rgbColor;

                        var brightness = (0.299 * dominantColor[0]) + (0.587 * dominantColor[1]) + (0.114 * dominantColor[2]);

                        // Définir la couleur du texte en fonction de la luminosité
                        if (brightness > 186) {
                            container.style.color = 'black'; // Fond clair, texte noir
                        } else {
                            container.style.color = 'white'; // Fond sombre, texte blanc
                        }
                    };

                    // Si l'image est déjà chargée (cache du navigateur), déclencher l'événement onload manuellement
                    if (img.complete) {
                        img.onload();
                    }
                })(i);
            }
        });
    </script>

    <script>
       
       document.addEventListener('DOMContentLoaded',function () {
         var recommanded=document.querySelectorAll('.carousel-item')
         fistCarousel=recommanded[0];
        fistCarousel.classList.add('active')
       })
    </script>
    <script>
        var likes=document.querySelectorAll('.btn-like');
        likes.forEach(function (like) {
            like.addEventListener('click', function likeAction(event) {
                event.preventDefault();
                evenement_id=like.getAttribute('data-event-id');
                unliked=like.querySelector('.bi-heart');
                liked=like.querySelector('.bi-heart-fill');
                unliked.classList.toggle('d-none');
                liked.classList.toggle('d-none');
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
                        url: '/like/event',
                        data:{
                            evenement_id: evenement_id,
                        },

                        dataType:'JSON',
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
    <script>
        function recommandedResponsive() {
            if (window.innerWidth<768) {
                var carouselContent = document.querySelectorAll(".recommended");
                var recommandedEventCard = document.querySelectorAll(".recommandedEventCard")
                var responsiveCarousel= document.getElementById('responsiveCarousel')
                carouselContent.forEach(function(item) {
                    // Récupérer le contenu de l'élément
                    var itemContent = item.innerHTML;
                    // Ajouter le contenu à l'élément avec l'ID responsiveCarousel
                    responsiveCarousel.innerHTML += itemContent;
                     
                    item.innerHTML="";

                    
                }
                )
                $('.button-carrousel').hide();
            }
            else{
                var carouselContent = document.querySelectorAll(".recommended");
                var responsiveCarousel = document.querySelectorAll('.recommandedEvent');
                var responsiveCarouselDiv= document.getElementById('responsiveCarousel');

                // Itérer sur chaque carouselContent
                carouselContent.forEach(function (item, index) {
                    // Calculer l'index de début dans responsiveCarousel
                    var startIndex = index * 4;
                   
                    // Prendre les 4 éléments suivants de responsiveCarousel
                    var responsiveItems = Array.from(responsiveCarousel).slice(startIndex, startIndex + 4);
                    // Ajouter chaque élément responsiveCarousel à l'élément carouselContent en cours
                    responsiveItems.forEach(function (responsiveItem) {
                        item.appendChild(responsiveItem);
                    });
                
                });
                responsiveCarouselDiv.innerHTML="";
                $('.button-carrousel').show();


            
            }
        
        }
        recommandedResponsive();

        window.addEventListener('resize', function() {
            // Code à exécuter lorsqu'il y a un changement de taille d'écran
            recommandedResponsive();
        });

    </script> 

    @endif
   
    @endsection 