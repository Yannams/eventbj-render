@extends('layout.utilisateur')
    @section('content')
    <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 g-3">
        <div class="col-lg-8">
            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-1 g-4">
                <div class="col">
                    <div class="card border-0 card-cover overflow-hidden text-bg-dark rouded-4 shadow-lg rounded" style="background-image: url('{{asset($evenement->cover_event)}}'); padding-bottom: 500px; background-size: cover;"></div>
                </div>
                <div class="col ">
                    <div class="card border-0 overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="fw-bold fs-1 p-2 flex-grow-1">{{$evenement->nom_evenement}}</div>
                                <div class="p-2 position-relative ">
                                    <img src="{{asset('image/Capture d’écran 2023-08-10 172019.jpg')}}" alt="" class="rounded-circle position-absolute" style="right: 60px;" height="35px"  width="35px">
                                    <img src="{{asset('image/Capture d’écran 2023-08-10 172138.jpg')}}" alt="" class="rounded-circle position-absolute" style="right: 30px;" height="35px"  width="35px">
                                    <img src="{{asset('image/Capture d’écran 2023-08-10 172248.jpg')}}" alt="" class="rounded-circle position-absolute" style="right: 0px;" height="35px"  width="35px">
                                </div>           
                            </div> 
                            <ul class="d-flex list-unstyled">
                                <li class="me-1 d-flex align-items-center"><svg class="bi bi-calendar4-week me-1" fill="#F0343C" width="1em" height="1em" ><use xlink:href="#calendar"></use></svg> {{$date->format('d/m/Y')}}<li>
                                <li class="d-flex align-items-center"><svg class="bi bi-geo-alt me-1" fill="#F0343C" width="1em" height="1em" ><use xlink:href="#geo"></use></svg> {{$evenement->localisation}}</li>
                            </ul>
                            <div class="fw-bold">Description</div>
                            <div>{{$evenement->description}}</div>
                        </div>
                    </div>
                </div>  
                <div class="col ">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="fw-bold mb-3">localisation</div>
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.3481168183457!2d2.405072108722263!3d6.348952493614397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023558e21b47881%3A0xe031d320e94f6b07!2sPlace%20de%20l&#39;amazone!5e0!3m2!1sen!2sbj!4v1698851464579!5m2!1sen!2sbj" width="750" height="450" style="border:0; border-radius:20px; margin-left:20px; margin-bottom:20px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="p-2 w-100 fw-bold">Voir le chronogramme</div>
                                <div class="p-2">
                                    <a class="btn" data-bs-toggle="collapse" href="#chronogramme" role="button" aria-expanded="false" aria-controls="chronogramme" id="" >
                                        <svg class="bi bi-plus"  fill="#F0343C" width="30" height="30">
                                            <use xlink:href="#plus"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>  
                           </div>
                    </div>
                   
                </div>
                <div class="col">
                    <div class="card border-0">
                        <div id="chronogramme" class="collapse" >
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                      <tr>
                                        <th scope="col">date</th>
                                        <th scope="col">heure début</th>
                                        <th scope="col">heure fin</th>
                                        <th scope="col">activité</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ( $chronogramme as $chronogrammes )
                                    <tr>
                                        <th scope="row"></th>
                                        <td>{{$chronogrammes->heure_debut}}</td>
                                        <td>{{$chronogrammes->heure_fin}}</td>
                                        <td>{{$chronogrammes->nom_activite}}</td>
                                      </tr>
                                    @endforeach
                                      
                                    </tbody>
                                  </table>
                            </div>
                            
                        </div>
                    </div>
                        

                </div>
                <div class="col ">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="p-2 w-100 fw-bold">ticket</div>
                                <div class="p-2">
                                    <a class="btn" data-bs-toggle="collapse" href="#ticket" role="button" aria-expanded="false" aria-controls="chronogramme" id="">
                                        <svg class="bi bi-plus border-3" fill="#F0343C" width="30" height="30">
                                            <use xlink:href="#plus"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div>   
                <div id="ticket" class="collapse"  >
                     @foreach ($ticket as $tickets )
                        <div class="col">
                            <div class="card border-0">
                                <div class="card-body">
                                    <div class="fw-bold fs-1">{{$tickets->nom_ticket}} </div>
                                    <div class="fw-bold fs-3">{{$tickets->prix_ticket}} XOF</div>
                                    <form action="{{route('ticket.create')}}" method="get">
                                        <input type="hidden" name="ticket" value="{{$tickets->id}}">
                                        <button type="submit" class="btn btn-primary w-100">Obtenir du ticket</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                      @endforeach
                              
                    </div> 
            </div>  
        </div> 
        <div class="col-lg-4">
            <div class="row g-3 row-cols-1 row-cols-md-1 row-cols-lg-1">
                <div class="col sticky-top">
                    <div class="card border-0 " >
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="p-2">
                                    <img src="{{asset('image/WhatsApp Image 2023-09-30 à 20.31.37_06f59849.jpg')}}" width="100" height="100" class="rounded-circle" alt="">
                                </div>
                                <div class="p-2">
                                    {{$organisateur->name}}
                                     <div class="fw-bold">Organisateur</div>
                                </div>
                            </div>
                        </div>     
                    </div>
                </div>
                @foreach ( $same_creator as $same_creators)
                <a href="{{route('evenement.show', ['evenement'=>$same_creators->id])}}" class="link-dark  link-offset-2 link-underline link-underline-opacity-0">
                    <div class="col">
                        <div class="card card-cover overflow-hidden text-bg-dark rounded-4 shadow-lg border-0 evenement " style="background-image: url('{{asset($same_creators->cover_event)}}'); background-size: cover;"> 
                            
                            <div class="gradient-overlay"></div>
                            <div class="badge tools-event mt-2 ms-2 rounded-3 card-header"> <span class="fs-3">{{date('d', strtotime($same_creators->date_heure_debut))}}</span> <br> <span class="fs-6">{{date('M', strtotime($same_creators->date_heure_debut))}}</span> </div>
                            <div class="card-body"><br><br><br></div>
                            <div class="card-footer d-flex">
                                <div class="fw-bold fs-4 p-2 w-100 ">{{$same_creators->nom_evenement}} </div>
                                <div  class="badge tools-event p-2 flex-shrink-1 rounded-3 ">
                                    <svg class="bi bi-heart " fill="currentColor" width="30" height="30" ><use xlink:href="#heart"></use></svg>
                                </div>
                            </div>
        
                        </div>
                        
                    </div>
                </a>
                    
                @endforeach
            </div>

            
            
        </div>
    </div>   
    <script src="https://cdn.kkiapay.me/k.js"></script>
    @endsection