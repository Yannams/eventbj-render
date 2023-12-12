@extends('layout.utilisateur')
    @section('content')
        @foreach ($ticket as $tickets)
        <div class="row">
        
            <div class="badge badge-tool text-dark col-4"><span class="fs-3">30</span><br><span>nov</span></div>
            <div class="card mb-3 border-0 col-8 m-5" style="max-width: 540px;">
                <div class="d-flex align-items-center">
                  <div class="p-2 w-25">
                    <img src="{{asset($tickets->code_QR)}}" class="img-fluid rounded-4 m-3" alt="..."  width="100px">
                  </div>
                  <div class="p-2">
                    <div class="card-body row">
                      <p class="card-text col-6 fw-bold">Tiakola en concert</p>
                      <p class="card-text col-4 fw-bold"  style="color: #308747"> A venir </p>
                      <div class="col-2"> <svg class="bi bi-download" fill="currentColor"  width="16" height="16"><use xlink:href="#download"></use></svg></div>

                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
        @endforeach
    @endsection