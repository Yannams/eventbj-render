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
                @endif
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom évènement</th>
                    <th scope="col">En ligne </th>
                    <th scope="col">Date début</th>
                    <th scope="col">Action</th>

                  </tr>
                </thead>
                <tbody>
                @foreach ($evenement as $evenements )
                <tr>
                    <th scope="row"><img src="{{asset($evenements->cover_event)}}" alt="" width="100" class="rounded"></th>
                    <td>{{$evenements->nom_evenement}}</td>
                    <td>@if ( $evenements->isOnline==false )
                      non-publié
                    @else
                      en ligne
                    @endif</td>
                    <td>{{$evenements->date_heure_debut}}</td>
                    <td class="d-flex">
                      <a href="" class="btn btn-secondary me-2">gérer</a>
                      <form action="{{route('OnlineEvents', ['evenement'=>$evenements->id])}}" method="post" >
                        @csrf
                        <button type="submit" class="btn btn-success me-2">Mettre en ligne</button>
                      </form>
                      <a href="" class="btn btn-primary me-2">Modifier l'évènement</a>
                      <form action="{{ route('evenement.destroy', $evenements) }}" method="POST" style="display: inline;" id="supprimer-etudiant-{{ $evenements->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
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