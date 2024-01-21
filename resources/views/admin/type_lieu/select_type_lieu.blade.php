@extends('layout.promoteur')
    @section('content')
    @include('layout.stepform')
    @error('type_lieu_event')
        <div class="position-relative">
            <div class="toast-container position-fixed bottom-0 end-0 translate-middle p-3 ">
                <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-body d-flex align-items-center">
                        <div class="p-2">
                            <svg class="bi bi-check-all" fill="#fff" width="30" height="30">
                                <use xlink:href="#error"></use>
                            </svg>
                        </div>
                        <div class="p-2 fw-bold ">Veuillez selectionner un type de lieu</div>
                        <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>    
        </div>
    @enderror
            <div class="row align-items-center">
                <form action="{{route('typelieuSelected')}}" method="post">
                    @csrf 
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="row row-cols-1 row-cols-md-1 row-cols-lg-1 g-3">
                                <div class="col">
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 g-3">
                                        @foreach ($type_lieu as  $type_lieus )
                                        <div class="col">
                                            <input type="radio" class="hidden-radio" name="type_lieu_event" id="{{$type_lieus->nom_type}}"  value="{{$type_lieus->id}}" autocomplete="off">
                                            <label class="@error('type_lieu_event') button-check-error @else button-check @enderror w-100 h-100" for="{{$type_lieus->nom_type}}">
                                                <h5>{{$type_lieus->nom_type}}</h5>
                                                <p>{{$type_lieus->description}}</p>
                                            </label>
                                        </div>    
                                    @endforeach
                                    </div>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-success w-100">Suivant</button>
                                </div>
                            </div>
                           
                        </div>    
                    </div>              
                    
                  
                </form>
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