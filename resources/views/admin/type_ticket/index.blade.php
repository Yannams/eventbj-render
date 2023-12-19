@extends('layout.promoteur')
    @section('content')
    <div class="container">
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
  <ul class="row row-cols-4 row-cols-lg-4 row-cols-md-4 nav nav-pills mb-4" id="pillNav" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="" class=" fw-bold nav-link rounded checked-step me-3" role="tab" aria-selected="true" >
            Type de lieu  
        </a>
    </li>          
    <li class="nav-item" role="presentation">
        <a href="{{route('evenement.create')}}" class=" fw-bold nav-link rounded checked-step me-3" role="tab" aria-selected="true" >
            Details de l’évènement
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="" class=" fw-bold nav-link rounded checked-step me-3" role="tab" aria-selected="true" >
            Date et heure
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="" class=" fw-bold nav-link rounded checked-step me-3" role="tab" aria-selected="true" >
            Création de ticket 
        </a>
    </li>                              
</ul>
    <div class="card border-0">
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{route('type ticket.create')}}" class="btn btn-primary text-end"> Ajouter un nouveau ticket</a>
              </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">prix </th>
                        <th scope="col">Quantité</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($typeTickets as $type_ticket )
                        <tr>
                            <th scope="row"><img src="{{$type_ticket->image_ticket}}" class="rounded" width="50px" alt=""></th>
                            <td>{{$type_ticket->nom_ticket}}</td>
                            <td>{{$type_ticket->prix_ticket}}</td>
                            <td>{{$type_ticket->place_dispo}}</td>
                        </tr>
                        @endforeach
                           
                    </tbody>
                  </table>
                  <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{route('MesEvenements')}}" class="btn btn-primary text-end">Suivant</a>
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
            </div>
        </div>
    </div>
     
      @endsection