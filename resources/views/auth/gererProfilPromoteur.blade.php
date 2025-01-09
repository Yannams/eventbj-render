@extends('layout.promoteur')
    @section('content')
    <div class="w-100 my-5 d-flex justify-content-center">
        @auth
            <img src="{{asset('image/WhatsApp Image 2023-09-30 à 20.31.37_06f59849.jpg')}}" alt="" width="200px" height="200px" class="rounded-circle">
        @else
        
            <i class="bi bi-person-circle text-dark" style="font-size: 200px" ></i>
        @endauth
        

    </div>

    <div class="card bg-light">
        <div class="card-body ms-4">
            @auth
                <div >
                    <a href="{{route('logout')}} "onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class=" d-flex justify-content-center align-items-center link-offset-2 link-underline link-underline-opacity-0">
                        <div class=" d-flex justify-content-center align-items-center rounded-2" style="width: 30px; height:30px; background-color:#308747; color:white">
                            <i class="bi bi-box-arrow-right" ></i>
                        </div>
                        <div class=" p-2 fw-bold text-dark">Se déconnecter</div>
                        <div class=" ms-auto "  style="color: #308747"><i class="bi  bi-chevron-right"></i></div>
                    </a>
                    <form  method="post" action="{{route('logout')}}"  id="logout-form" style="display: none">
                        @csrf
                    </form>
                </div>  
            @else
                <div>
                    <a href="{{route('login')}} "  class=" d-flex  align-items-center link-offset-2 link-underline link-underline-opacity-0">
                        <div class=" d-flex justify-content-center align-items-center rounded-2" style="width: 30px; height:30px; background-color:#308747; color:white">
                            <i class="bi  bi-box-arrow-in-right" ></i>
                        </div>
                        <div class="p-2">    
                            <div class=" fw-bold text-dark" >Se connecter</div>
                        </div>
                        <div class="ms-auto"  style="color: #308747"><i class="bi  bi-chevron-right"></i></div>
                    </a>
            </div>
            <hr class="ms-4">
            <div>
                <a href="{{route('register')}}" class=" d-flex justify-content-center align-items-center link-offset-2 link-underline link-underline-opacity-0">
                    <div class="d-flex justify-content-center align-items-center rounded-2" style="width: 30px; height:30px; background-color:#308747; color:white">
                        <i class="bi  bi-person-add" ></i>
                    </div>
                    <div class="p-2 fw-bold text-dark">S'inscrire</div>
                    <div class="ms-auto" style="color: #308747"><i class="bi  bi-chevron-right"></i></div>
                </a>
            </div>
            
            @endauth
            
            <hr class="ms-4">
            <div>
                <a href="{{route('evenement.index')}}" class="d-flex justify-content-center align-items-center link-offset-2 link-underline link-underline-opacity-0">
                    <div class="d-flex justify-content-center align-items-center rounded-2" style="width: 30px; height:30px; background-color:#308747; color:white">
                        <i class="bi bi-person-up" ></i>
                    </div>
                    <div class="p-2 fw-bold text-dark">Permuter vers participant </div>
                    <div class="ms-auto ms-5"  style="color: #308747"><i class="bi  bi-chevron-right"></i></div>
                </a>
            </div>
        </div>
    </div>
    @endsection