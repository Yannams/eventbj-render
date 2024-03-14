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

 
    <div class="border-0 rounded-4">
        <div class="">
            
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="d-flex">
                    <h1 class="p-2 flex-grow-1 fw-bold">A la une</h1>
                    <div class="p-2 me-2 d-none d-lg-inline">
                        <button class="button-carrousel p-2" id="prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="bi bi-caret-left-fill" aria-hidden="true"><svg class="bi bi-caret-right-fill" fill="currentColor" width="32" height="32"><use xlink:href="#previous-button"></use></svg> </span>
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
                  <div class="carousel-item active">
                       <div class="row row-cols-1 row-cols-md-4 g-3 mb-4 scrolling-wrapper recommended flex-nowrap">
                            <div class="col recommandedEvent ">
                                <div class="card low-padding rounded-4 border-0 card-size recommandedEventCard" style="background-color:#F0343C; ">
                                    <img src="{{asset('image/img.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">ZeChill</h5>
                                        <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                        <div class="text-end">
                                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col recommandedEvent">
                                <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#FBAA0A;">
                                    <img src="{{asset('image/Capture d’écran 2023-08-10 170824.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">ZeChill</h5>
                                        <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                        <div class="text-end">
                                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col recommandedEvent">
                                <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#308747;">
                                    <img src="{{asset('image/Capture d’écran 2023-08-10 172019.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">ZeChill</h5>
                                        <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                        <div class="text-end">
                                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col recommandedEvent">
                                <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#B1B3C8;">
                                    <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">ZeChill</h5>
                                        <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                        <div class="text-end">
                                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                       </div>
                  </div>
                  <div class="carousel-item">
                    <div class="row row-cols-1 row-cols-md-4 g-3 mb-4 scrolling-wrapper recommended flex-nowrap">
                        <div class="col recommandedEvent">
                            <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#B1B3C8;">
                                <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">ZeChill</h5>
                                    <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                     <div class="text-end">
                                    <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="col recommandedEvent">
                            <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#B1B3C8;">
                                <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">ZeChill</h5>
                                    <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                     <div class="text-end">
                                        <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="col recommandedEvent">
                            <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#B1B3C8;">
                                <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">ZeChill</h5>
                                    <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                     <div class="text-end">
                                        <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                        <div class="col recommandedEvent">
                            <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#B1B3C8;">
                                <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">ZeChill</h5>
                                    <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                     <div class="text-end">
                                        <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                  </div>
                  <div class="carousel-item">
                       <div class="row row-cols-1 row-cols-md-4 g-3 mb-4 scrolling-wrapper recommended flex-nowrap">
                            <div class="col recommandedEvent">
                                <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#B1B3C8;">
                                    <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">ZeChill</h5>
                                        <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                        <div class="text-end">
                                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col recommandedEvent">
                                <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#B1B3C8;">
                                    <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">ZeChill</h5>
                                        <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                        <div class="text-end">
                                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col recommandedEvent">
                                <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#B1B3C8;">
                                    <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">ZeChill</h5>
                                        <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                        <div class="text-end">
                                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col recommandedEvent">
                                <div class="card rounded-4 border-0 card-size recommandedEventCard" style=" background-color:#B1B3C8;">
                                    <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:150px; height:150px;" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">ZeChill</h5>
                                        <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                                        <div class="text-end">
                                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                       </div>
                  </div>
                </div>
                
            </div>
        </div>
    </div>
       
   
  
    <div class="menu-container">
        <ul class="menu" >
            <li class="">
                <a href="{{ route('evenement.index') }}" class="@if (request()->url() == route('evenement.index')) active-link @else non-active @endif">
                    Tout
                </a>
                
            </li>
            @foreach ( $type_evenement as $key => $type_evenements )
                <li class="">
                    <a href="{{ route('type_event', ['type' => $type_evenements->id]) }}" class="@if (request()->url() == route('type_event', ['type' => $type_evenements->id])) active-link @else non-active @endif">
                        {{ $type_evenements->nom_type_evenement }}
                    </a>
                   
                </li>
            @endforeach
            
        </ul>
    </div>

    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-4">
        @foreach ( $evenement as $evenements )
        <a href="{{route('evenement.show', ['evenement'=>$evenements->id])}}" class="link-dark  link-offset-2 link-underline link-underline-opacity-0">
            <div class="col">
                <div class="card shadow card-cover overflow-hidden text-bg-dark rounded-4 shadow-lg border-0 evenement shadow" style="height: 250px;"> 
                    <img src="{{$evenements->cover_event}}" class="card-img h-100" alt="...">
                    <div class="card-img-overlay flex-column">
                        <div class="badge tools-event pb-5 mb-5 rounded-3 card-header"> <span class="fs-3">{{date('d', strtotime($evenements->date_heure_debut))}}</span> <br> <span class="fs-6">{{date('M', strtotime($evenements->date_heure_debut))}}</span> </div>
                        <div class="d-flex mt-5 pt-4">
                            <div class="fw-bold fs-4 p-2 w-100 ">{{$evenements->nom_evenement}} </div>
                            <div  class="badge tools-event p-2 d-flex align-items-center flex-shrink-1 rounded-3 ">
                                <svg class="bi bi-heart " fill="currentColor" width="30" height="30" ><use xlink:href="#heart"></use></svg>
                            </div>
                        </div>
                    </div>

                </div>
                
            </div>
        </a>
          
        @endforeach
    </div>
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

                    console.log(recommandedEventCard);
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