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
                
            <table class="table align-middle">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom évènement</th>
                    <th scope="col">En ligne </th>
                    <th scope="col">Date et heure début</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>
                <tbody>
                @foreach ($evenement as $evenements )
                <tr class="">
                    
                    <th scope="row"><img src="{{asset($evenements->cover_event)}}" alt="cover" width="100" class="rounded"></th>
                    <td>{{$evenements->nom_evenement}}</td>
                    <td>@if ( $evenements->isOnline==false )
                      non-publié
                    @else
                      en ligne
                    @endif</td>
                    <td>{{date('d/m/Y à h:i', strtotime($evenements->date_heure_debut))}}</td>
                    <td>
                    <div class="row row-cols-2 row-cols-md-2 row-cols-lg-2">
                        <div class="col">
                            <form action="{{route('OnlineEvents', ['evenement'=>$evenements->id])}}" method="post" >
                                @csrf
                                <button type="submit" class="btn btn-success">Mettre en ligne</button>
                            </form>
                           
                        </div>
                        <div class="col">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                  Dropdown
                                </button>
                                <ul class="dropdown-menu">
                                  <li>
                                    <a href="" class=" dropdown-item">gérer</a>
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
                                    <a href="{{route('evenement.show', $evenements)}}" class="dropdown-item"> voir</a>
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
          document.addEventListener('DOMContentLoaded', function () {
              const toastLiveExample = document.getElementById('liveToast');

              if (toastLiveExample) {
                  const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                  toastBootstrap.show();
              }
          });
      </script>
    @endsection