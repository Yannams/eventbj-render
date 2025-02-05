@extends('layout.promoteur')
    @section('content')
        <div class="card border-0 shodow">
            <div class="card-body">
                <div class="d-flex justify-content-center p-5">
                    <a href="{{route('controleur.index')}}" class="btn btn-warning text-white w-25 h-100 me-5 ">
                        <div class="d-flex flex-column">
                            <i class="bi bi-person-check-fill fs-1"></i>
                            <span>Contrôleur de ticket</span>
                        </div>
                    </a>
                    <a href="{{route('eventToVerify')}}" class="btn btn-danger text-white w-25 h-100 ">
                        <div class="d-flex flex-column">
                            <i class="bi bi-qr-code-scan fs-1"></i>
                            <span>Scanner ticket</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    @endsection