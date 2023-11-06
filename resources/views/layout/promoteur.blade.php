<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="image/WhatsApp_Image_2023-09-01_à_17.16.15-removebg-preview (1).png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>eventbj</title>

</head>
<body>
   <div class="container-fluid">
      <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
   
              <a href="{{route('evenement.index')}}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <img src="{{ asset('image/WhatsApp_Image_2023-09-01_à_17.16.15-removebg-preview (1).png') }}" alt="eventbj" height="70" width="70">
              </a>
               <form action="" class="me-5 w-25 mt-2">
                  <input type="search" name="" id="" class="form-control rounded-pill border-4 " placeholder="rechercher...">
               </form>
              <ul class="nav nav-underline mt-1">
                <li class="nav-item"></li>
                <li class="nav-item"><a href="#" class="nav-link active " aria-current="page">Home</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Mes tickets</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Découvrir</a></li>
                <li class="nav-item"><a href="#" class="nav-link">Créer un évènement</a></li>                
              </ul>
              <img src="image/WhatsApp Image 2023-09-30 à 20.31.37_06f59849.jpg" alt="profil" width="50" height="50" class="rounded-5 ms-4" >

       </header>
       <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
        <symbol id="plus" viewBox="0 0 16 16">
          <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
        </symbol>
      </svg>
       @yield('content')
     </div>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-bwJ3NRRpZy9bCaOa14DE9q79zFbQA7SH3uMKr6Pz3bMLcfmI7RmCmAE8XMErWsRn" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>