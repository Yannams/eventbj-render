@extends('layout.utilisateur')
    @section('content')
   
    <h1 class="p-2 flex-grow-1 text ">Populaires</h1>    
    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
               <div class="row row-cols-1 row-cols-md-4 g-3 mb-4 scrolling-wrapper flex-nowrap">
                    <div class="col">
                        <div class="card rounded-4 border-0" style="width: 18rem; background-color:#F0343C; ">
                            <img src="{{asset('image/img.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">ZECHILL</h5>
                                <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                            </div>
                            <div class="card-body text-end">
                                <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4 border-0" style="width: 18rem; background-color:#FBAA0A;">
                            <img src="{{asset('image/Capture d’écran 2023-08-10 170824.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="max-width: 70%;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">ZECHILL</h5>
                                <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                            </div>
                            <div class="card-body text-end">
                                <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4 border-0" style="width: 18rem; background-color:#308747;">
                            <img src="{{asset('image/Capture d’écran 2023-08-10 172019.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">ZECHILL</h5>
                                <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                            </div>
                            <div class="card-body text-end">
                                <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4 border-0" style="width: 18rem; background-color:#B1B3C8;">
                            <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">ZECHILL</h5>
                                <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                            </div>
                            <div class="card-body text-end">
                                <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                            </div>
                        </div>
                    </div>
               </div>
          </div>
          <div class="carousel-item">
            <div class="row row-cols-1 row-cols-md-4 g-3 mb-4 scrolling-wrapper flex-nowrap">
                <div class="col">
                    <div class="card rounded-4 border-0" style="width: 18rem; background-color:#B1B3C8;">
                        <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">ZECHILL</h5>
                            <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                        </div>
                        <div class="card-body text-end">
                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 border-0" style="width: 18rem; background-color:#B1B3C8;">
                        <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">ZECHILL</h5>
                            <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                        </div>
                        <div class="card-body text-end">
                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 border-0" style="width: 18rem; background-color:#B1B3C8;">
                        <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">ZECHILL</h5>
                            <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                        </div>
                        <div class="card-body text-end">
                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card rounded-4 border-0" style="width: 18rem; background-color:#B1B3C8;">
                        <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">ZECHILL</h5>
                            <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                        </div>
                        <div class="card-body text-end">
                            <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div class="carousel-item">
               <div class="row row-cols-1 row-cols-md-4 g-3 mb-4 scrolling-wrapper flex-nowrap">
                    <div class="col">
                        <div class="card rounded-4 border-0" style="width: 18rem; background-color:#B1B3C8;">
                            <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">ZECHILL</h5>
                                <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                            </div>
                            <div class="card-body text-end">
                                <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4 border-0" style="width: 18rem; background-color:#B1B3C8;">
                            <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">ZECHILL</h5>
                                <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                            </div>
                            <div class="card-body text-end">
                                <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4 border-0" style="width: 18rem; background-color:#B1B3C8;">
                            <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">ZECHILL</h5>
                                <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                            </div>
                            <div class="card-body text-end">
                                <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card rounded-4 border-0" style="width: 18rem; background-color:#B1B3C8;">
                            <img src="{{asset('image/be0d79da59dd006922e619434bf0df11.jpg')}}" class="card-img-top rounded-circle mx-auto mt-3 mb-3" style="width:200px; height:200px;" alt="...">
                            <div class="card-body">
                                <h5 class="card-title fw-bold">ZECHILL</h5>
                                <p class="card-text d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="currentColor" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> 22/12/23</p>
                            </div>
                            <div class="card-body text-end">
                                <a href="#" class="btn rounded-4" style="background-color: #ffffff;"><b>Voir plus...</b></a>
                            </div>
                        </div>
                    </div>
               </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div>
           
    <h1 class="my-4">Categories</h1>
    <ul class="nav nav-pills mb-4" id="pillNav" role="tablist">
    @foreach ($type_evenement as $key => $type_evenements )
        <li class="nav-item" role="presentation">
            <a href="{{ route('type_event', ['type' => $type_evenements->id]) }}" class=" fw-bold nav-link @if (request()->url() == route('type_event', ['type' => $type_evenements->id])) active-link @else non-active @endif rounded-pill  me-3" role="tab" aria-selected="true" >
                {{ $type_evenements->nom_type_evenement }}
            </a>
        </li>
    @endforeach
</ul>

    
  
        {{-- @if()
            <a href="{{route('evenement.index')}}"><span class="badge rounded-pill text-bg-success" ></span></a>
        @else
            <a href="{{route('type_event', ['type'=>$type_evenements->id])}}"><span class="badge rounded-pill text-black border border-success">{{$type_evenements->nom_type_evenement}}</span></a>
        @endif --}}
    

    
        <h1 class="my-4">Vos évènements</h1>
    <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
        @foreach ( $evenement as $evenements )
        <a href="{{route('evenement.show', ['evenement'=>$evenements->id])}}" class="link-dark  link-offset-2 link-underline link-underline-opacity-0">
            <div class="col">
                <div class="card card-cover overflow-hidden text-bg-dark rounded-4 shadow-lg border-0 evenement " style="background-image: url('{{asset($evenements->cover_event)}}'); background-size: cover;"> 
                    
                    <div class="gradient-overlay"></div>
                    <div class="badge tools-event mt-2 ms-2 rounded-3 card-header"> <span class="fs-3">{{date('d', strtotime($evenements->date_heure_debut))}}</span> <br> <span class="fs-6">{{date('M', strtotime($evenements->date_heure_debut))}}</span> </div>
                    <div class="card-body"><br><br><br></div>
                    <div class="card-footer d-flex">
                        <div class="fw-bold fs-4 p-2 w-100 ">{{$evenements->nom_evenement}} </div>
                        <div  class="badge tools-event p-2 flex-shrink-1 rounded-3 ">
                            <svg class="bi bi-heart " fill="currentColor" width="30" height="30" ><use xlink:href="#heart"></use></svg>
                        </div>
                    </div>

                </div>
                
            </div>
        </a>
          
        @endforeach
    </div>
        
    
       
    @endsection 