<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="icon" href="{{asset('image/WhatsApp_Image_2023-09-01_à_17.16.15-removebg-preview (1).png')}}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>eventbj</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <style>
      {!! Vite::content('resources/css/app.css') !!}
    </style>
</head>
<body>
        <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 " style="background-color: #C3E3CC">
                        <div id="carouselExampleCaptions" class="carousel slide">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="4" aria-label="Slide 5"></button>
                            </div>
                            <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="p-5" style=" height:30em">
                                    <img src="{{asset('image/undraw_festivities_tvvj.svg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="text-white text-center mb-5 d-none d-md-block">
                                <h5>First slide label</h5>
                                <p>Some representative placeholder content for the first slide.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="p-5" style=" height:30em">
                                    <img src="{{asset('image/undraw_having_fun_re_vj4h.svg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="text-white text-center mb-5 d-none d-md-block">
                                <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="p-5" style="height:30em">
                                    <img src="{{asset('image/undraw_special_event_-4-aj8.svg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="text-white text-center mb-5 d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="p-5" style="height:30em">
                                    <img src="{{asset('image/undraw_events_re_98ue.svg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="text-white text-center mb-5 d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <div class="p-5" style="height:30em">
                                    <img src="{{asset('image/undraw_investor_update_re_qnuu.svg')}}" class="d-block w-100" alt="...">
                                </div>
                                <div class="text-white text-center mb-5 d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                                </div>
                            </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon text-dark" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center">
                        <form action="{{route('register')}}" method="post">
                        @csrf
                        <div class="col-12">   
                            <div class="row mb-2">
                                <label for="name" class="col-12 col-form-label text-start">{{ __('Name') }}</label>

                                <div class="col-12">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label for="email" class="col-12 col-form-label text-start">{{ __('Email Address') }}</label>

                                <div class="col-12">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label for="num_user" class="col-12 col-form-label text-start">{{ __('Numéro') }}</label>

                                <div class="col-12">
                                    <input id="num_user" type="num_user" class="form-control @error('num_user') is-invalid @enderror" name="num_user" value="{{ old('num_user') }}" required >

                                    @error('num_user')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label for="password" class="col-12 col-form-label text-start">{{ __('Password') }}</label>

                                <div class="col-12">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm" class="col-12 col-form-label text-md-">{{ __('Confirm Password') }}</label>

                                <div class="col-12">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success w-100">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-5">
                                <hr>
                            </div>
                            <span class="col-2 text-center">or</span>
                            <div class="col-5"><hr></div>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <div class="flex-shrink"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="30px" height="30px"><path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"></path><path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"></path><path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"></path><path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"></path></svg></div>
                                        <span class="px-2 fw-bold">Google</span>
                                    </div>
                                </div>
                               
                            </div>
    
                            <div class="col-6">
                                <div class="card">
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <div class=" flex-shrink"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" width="30px" height="30px"><path d="M 44.527344 34.75 C 43.449219 37.144531 42.929688 38.214844 41.542969 40.328125 C 39.601563 43.28125 36.863281 46.96875 33.480469 46.992188 C 30.46875 47.019531 29.691406 45.027344 25.601563 45.0625 C 21.515625 45.082031 20.664063 47.03125 17.648438 47 C 14.261719 46.96875 11.671875 43.648438 9.730469 40.699219 C 4.300781 32.429688 3.726563 22.734375 7.082031 17.578125 C 9.457031 13.921875 13.210938 11.773438 16.738281 11.773438 C 20.332031 11.773438 22.589844 13.746094 25.558594 13.746094 C 28.441406 13.746094 30.195313 11.769531 34.351563 11.769531 C 37.492188 11.769531 40.8125 13.480469 43.1875 16.433594 C 35.421875 20.691406 36.683594 31.78125 44.527344 34.75 Z M 31.195313 8.46875 C 32.707031 6.527344 33.855469 3.789063 33.4375 1 C 30.972656 1.167969 28.089844 2.742188 26.40625 4.78125 C 24.878906 6.640625 23.613281 9.398438 24.105469 12.066406 C 26.796875 12.152344 29.582031 10.546875 31.195313 8.46875 Z"></path></svg></div>
                                        <span class="px-2 fw-bold">  Apple</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="col">
                            <span>Vous avez déja un compte ?</span><a href="{{route('login')}}" class="link-success">Connectez-vous!</a> 
                        </div>
                        </form>

                      
                    
                    </div>
                </div>
        </div>
    
</body>
</html>

