@extends('layout.promoteur')
    @section('content')
        <div class="card border-0 shodow">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-3 g-3">
                    <div class="col">
                        <a href="{{route('EventToControl')}}" class="btn btn-success text-white w-100  h-100 me-5 p-4">
                            <div class="d-flex flex-column">
                                <i class="bi bi-list-check fs-1"></i>
                                <span>Mes vérifications</span>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{route('controleur.index')}}" class="btn btn-warning text-white w-100  h-100 me-5 p-4">
                            <div class="d-flex flex-column">
                                <i class="bi bi-person-check-fill fs-1"></i>
                                <span>Contrôleur de ticket</span>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{route('eventToVerify')}}" class="btn btn-danger text-white w-100  h-100 p-4">
                            <div class="d-flex flex-column">
                                <i class="bi bi-qr-code-scan fs-1"></i>
                                <span>Scanner ticket</span>
                            </div>
                        </a>
                    </div>
                   
                    
                  
                </div>
            </div>
        </div>
    @endsection