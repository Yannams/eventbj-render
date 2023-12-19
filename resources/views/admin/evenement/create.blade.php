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
    <ul class="row row-cols-4 row-cols-lg-4 row-cols-md-4 nav nav-pills mb-4" id="pillNav" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{route('select_type_lieu')}}" class=" fw-bold nav-link rounded checked-step me-3" role="tab" aria-selected="true" >
                Type de lieu  
            </a>
        </li>          
        <li class="nav-item" role="presentation">
            <a href="{{route('evenement.create')}}" class=" fw-bold nav-link rounded unchecked-step me-3" role="tab" aria-selected="true" >
                Details de l’évènement
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="" class=" fw-bold nav-link rounded unchecked-step me-3" role="tab" aria-selected="true" >
                Date et heure
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="" class=" fw-bold nav-link rounded unchecked-step me-3" role="tab" aria-selected="true" >
                Création de ticket 
            </a>
        </li>                              
    </ul>
    <div class="card border-0">
        <div class="card-body">
            <form action="{{route('evenement.store')}}" method="post" enctype="multipart/form-data" class="m-3">
                @csrf
                
     
                     <div class="col-12 mb-3 custom-file card rounded-4">
                         <input type="file" name="cover_event" id="cover_event" class="form-control custom-file-input">
                         <label for="cover_event" class="custom-file-label p-5" style="background-image: url({{asset('image/concert.jpeg')}}); background-size: cover;">
                             <div class="align-items-center"  style="border: dotted; border-width:2px;">
                                 <div class="card-body p-5">Ajoutez une photo de couverture</div>
                             </div>
                         </label>
                     </div>
                     <div class="col-12 mb-3">
                         <label for="nom_evenement">Nom evenement</label>
                         <input type="text" name="nom_evenement" id="nom_evenement" class="form-control">
                     </div>
                     <div class="col-12 mb-3">
                         <label for="type_evenement_id">Type de l'evenement</label>
                         <select name="type_evenement_id" id="type_evenement_id" class="form-control">
                            @foreach ($type_evenement as $type_evenements )
                                 <option value="{{$type_evenements->id}}">{{$type_evenements->nom_type_evenement}}</option>
                            @endforeach 
                             
                         </select>
                     </div>
                     <div class="col-12 mb-3">
                         <label for="localisation">Localisation</label>
                         <input type="text" name="localisation" id="localisation" class="form-control">
                     </div>
                     <div class="col-12 mb-3">
                         <label for="description">Description</label>
                         <textarea name="description" id="description" cols="30" rows="10" class="form-control"></textarea>
                     </div>
                     <div></div>
                     <input type="hidden" name="type_lieu_selected" value="{{$typeLieuId}}">
                     <div class="col-12 mb-3">
                         <button type="submit" class="btn btn-primary">Suivant</button>    
                     </div>         
            </form>
     
        </div>      
    </div>
      
        <script>
            $(document).ready(function() {
                // Lorsque le champ de fichier change
                $('#cover_event').on('change', function() {
                    var input = this;
                    var label = $(input).next('.custom-file-label');
                    var fileName = input.files[0].name;
        
                    // Afficher le nom du fichier dans le label
                    label.find('.card-body').text(fileName);
        
                    // Charger l'image sélectionnée comme fond du label
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        label.css('background-image', 'url(' + e.target.result + ')');
                    };
                    reader.readAsDataURL(input.files[0]);
        
                    // Mettre à jour la bordure du label (facultatif)
                    label.css('border-color', 'transparent');
                });
            });
        </script>
          <script>
            document.addEventListener('DOMContentLoaded', function () {
                const toastLiveExample = document.getElementById('liveToast');
                if (toastLiveExample) {
                    const toastBootstrap = new bootstrap.Toast(toastLiveExample);
                    toastBootstrap.show();
                }
            });
        </script>
    </div>    
    @endsection
