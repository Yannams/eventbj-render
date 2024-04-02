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
    @include('layout.stepform')
    <div class="card border-0">
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{route('type_ticket.create')}}" class="btn btn-success text-end"> Ajouter un nouveau ticket</a>
              </div>
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nom</th>
                        <th scope="col">prix </th>
                        <th scope="col">Quantité</th>
                        <th scope="col"> Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($typeTickets as $type_ticket )
                        <tr>
                            <th scope="row"><img src="{{$type_ticket->image_ticket}}" class="rounded" width="50px" alt=""></th>
                            <td>{{$type_ticket->nom_ticket}}</td>
                            <td>{{$type_ticket->prix_ticket}}</td>
                            <td>{{$type_ticket->place_dispo}}</td>
                            <td>
                                <a href="{{route('type_ticket.edit',$type_ticket->id)}}" class="btn btn-success">Modifier</a>
                            </td>
                        </tr>
                        @endforeach
                           
                    </tbody>
                  </table>
                  <div class="row mt-5">
                    <div class="col">
                        <a href="" class="btn btn-outline-success w-100">Précédent</a>
                    </div>
                    <div class="col">
                        <a href="{{route('terminus')}}" class="btn btn-success w-100">Terminer</a>
                    </div>
                    
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