@extends('layout.promoteur')
    @section('content')
    <div class="container">
        <form action="{{route('evenement.store')}}" method="post" enctype="multipart/form-data">
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
    </div>    
    @endsection
