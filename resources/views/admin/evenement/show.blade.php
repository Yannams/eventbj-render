@extends('layout.utilisateur')
    @section('content')
    <div class="row g-3">
        <div class="col-8">
            <div class="row g-3 mb-3 ms-3">
                <div class="col-12">
                    <div class="card border-0 card-cover overflow-hidden text-bg-dark rouded-4 shadow-lg rounded" style="background-image: url('{{asset($evenement->cover_event)}}'); padding-bottom: 500px; background-size: cover;"></div>
                </div>
                <div class="col-12 card border-0 overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="fw-bold fs-1 p-2 w-75">{{$evenement->nom_evenement}}</div>
                            <div class="p-2 d-flex flex-row">
                                <img src="{{asset('image/Capture d’écran 2023-08-10 172019.jpg')}}" alt="" width="53px" height="53px" class="rounded-circle img-fluid">
                                <img src="{{asset('image/Capture d’écran 2023-08-10 172138.jpg')}}" alt="" width="53px" height="53px" class="rounded-circle img-fluid ">
                                <img src="{{asset('image/Capture d’écran 2023-08-10 172248.jpg')}}" alt="" width="53px" height="53" class="rounded-circle img-fluid">
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
                <div class="col-12 card border-0">
                    <div class="card-body">
                        <div class="fw-bold mb-3">localisation</div>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.3481168183457!2d2.405072108722263!3d6.348952493614397!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1023558e21b47881%3A0xe031d320e94f6b07!2sPlace%20de%20l&#39;amazone!5e0!3m2!1sen!2sbj!4v1698851464579!5m2!1sen!2sbj" width="750" height="450" style="border:0; border-radius:20px; margin-left:20px; margin-bottom:20px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    </div>
                </div>
                <div class="col-12 card border-0 mb-3 ms-3">
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
                              
         
                <div class="col-12 card border-0 ms-3 mb-3">
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
                <div class="card border-0 ms-3 mb-3">
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
                   
                <div id="ticket" class="collapse mt-3"  >
                            
                                
                            @foreach ($ticket as $tickets )
                                <div class="col-12 card border-0 ms-3 mb-3">
                                    <div class="card-body">
                                        <div class="fw-bold fs-1">{{$tickets->nom_ticket}} </div>

                                        <form action="{{route('ticket.create')}}" method="get">
                                            <input type="hidden" name="ticket" value="{{$tickets->id}}">
                                            <button type="submit" class="btn btn-primary">Obtenir du ticket</button>
                                        </form>
                                        {{-- <kkiapay-widget amount="{{$tickets->prix_ticket}}" 
                                            key="d996a8407a9111eea7c1213b731c024f"
                                            position="center"
                                            sandbox="true"
                                            data=""
                                            callback="{{route('ticket.store')}}">
                                        </kkiapay-widget>  --}}
                                    </div>
                                </div>
                            @endforeach
                              
                    </div> 
            </div>  
            
        <div class="col-4">

            <div class="card border-0">
                <div class="card-body">
                    <div class="row g-3 my-2 ms-2">
                        <div class="col-4">
                            <img src="{{asset('image/WhatsApp Image 2023-09-30 à 20.31.37_06f59849.jpg')}}" width="100" height="100" class="rounded-circle" alt="">
                        </div>
                        <div class="col-8">
                            {{$organisateur->name}}
                             <div class="fw-bold">Organisateur</div>
                        </div>
                    </div>
                </div>     
            </div>
            
        </div>
    </div>   
    <script src="https://cdn.kkiapay.me/k.js"></script>
    @endsection