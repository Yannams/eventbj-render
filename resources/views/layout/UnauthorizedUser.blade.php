@extends('layout.promoteur')
    @section('content')
    <div class="d-flex align-items-center justify-content-center" style="height: 500px">   
        <div>
            <div class="w-100 text-center mb-5">
                <i class="bi bi-exclamation-triangle bg-danger text-white p-4 fs-1 rounded-circle text-center" ></i>
            </div>
            <div class="fw-bold fs-4">
                Cet utilisateur n'a pas les autorisations nécessaire pour effectuer cette action!
            </div>
        </div>
    </div>
    @endsection