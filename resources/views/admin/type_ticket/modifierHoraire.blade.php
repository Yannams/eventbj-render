@extends('layout.promoteur')
@section('content')
<form action="{{route('UpdateHoraire')}}" method="post" novalidate class="needs-validation">
    @csrf   
    @foreach ($typeTicketAprogrammer as $typeTicket)
        <div class="fs-3 fw-bold"> {{$typeTicket->nom_ticket}}</div>
        <div class="card border-0 ms-3 mb-3 shadow">
            <div class="card-body">
                <input type="hidden" name="type_ticket_id[{{$typeTicket->id}}]" value="{{$typeTicket->id}}" required>
                <div class="col-12 mb-3">
                    <label for="methodeProgrammationLancement">Date d'ouverture de la billetterie</label>
                   <select name="methodeProgrammationLancement[{{$typeTicket->id}}]" id="methodeProgrammationLancement" class="form-select" required data-type-ticket="{{$typeTicket->id}}">
                        <option value=""></option>
                        <option value="ActivationEvènement" @if ($typeTicket->methodeProgrammationLancement=='ActivationEvènement')selected @endif>Au moment où l'évènement est activé</option>
                        <option value="ProgrammerBilleterie" @if ($typeTicket->methodeProgrammationLancement=='ProgrammerBilleterie')selected @endif>Programmer ...</option>
                        <option value="ProgrammerPlustard" @if ($typeTicket->methodeProgrammationLancement=='ProgrammerPlustard')selected @endif>Programmer plus tard</option>
                   </select>
                </div>
                <div id="programmerLancement[{{$typeTicket->id}}]">

                </div>
                
                <div class="col-12 mt-3 mb-3">
                    <label for="methodeProgrammationFermeture">Date de fermeture de la billetterie</label>
                    <select name="methodeProgrammationFermeture[{{$typeTicket->id}}]" id="methodeProgrammationFermeture" class="form-select" required data-type-ticket="{{$typeTicket->id}}">
                         <option value=""></option>
                         <option value="FinEvenement" @if ($typeTicket->methodeProgrammationFermeture=='FinEvenement')selected @endif>Date de fin de l'evenement</option>
                         <option value="ProgrammerFermeture" @if ($typeTicket->methodeProgrammationFermeture=='ProgrammerFermeture')selected @endif>Programmer ...</option>
                         <option value="ProgrammerPlustard" @if ($typeTicket->methodeProgrammationFermeture=='ProgrammerPlustard')selected @endif>Programmer plus tard</option>
                    </select>
                </div>
                <div id="programmerFermeture[{{$typeTicket->id}}]">
                    
                </div>

            </div>
        </div>  
        
           
    @endforeach
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </div>
</div>
</form>
<script>
    (() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
<script>
   
    var methodeProgrammationLancements=document.querySelectorAll("#methodeProgrammationLancement");
    methodeProgrammationLancements.forEach(function (methodeProgrammationLancement) {
        methodeProgrammationLancement.addEventListener('change',function programmerLancement() {
            typeticket_id=methodeProgrammationLancement.getAttribute('data-type-ticket');
            DateVal=$(this).val()
            if(DateVal==="ProgrammerBilleterie"){
                
                document.getElementById('programmerLancement['+typeticket_id+']').innerHTML="<label for=\"Date_heure_lancement\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_lancement["+typeticket_id+"]\" id=\"Date_heure_lancement\" class=\"form-control\" required min=\"{{now()->format('Y-m-d h:i')}}\"  value=\"{{$typeTicket->Date_heure_lancement}}\"> <div class=\"invalid-feedback\">La date de lancement doit être supérieur à la date du jour et inférieur à la date de fermeture</div>"
            }else{
                document.getElementById('programmerLancement['+typeticket_id+']').innerHTML=""
            }
        })
    });
    var methodeProgrammationLancements=document.querySelectorAll("#methodeProgrammationLancement");
    methodeProgrammationLancements.forEach(function (methodeProgrammationLancement) {
        document.addEventListener('DOMContentLoaded',function programmerLancement() {
            typeticket_id=methodeProgrammationLancement.getAttribute('data-type-ticket');
            DateVal=$(this).val()
            if(DateVal==="ProgrammerBilleterie"){
                
                document.getElementById('programmerLancement['+typeticket_id+']').innerHTML="<label for=\"Date_heure_lancement\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_lancement["+typeticket_id+"]\" id=\"Date_heure_lancement\" class=\"form-control\" required min=\"{{now()->format('Y-m-d h:i')}}\"  value=\"{{$typeTicket->Date_heure_lancement}}\"> <div class=\"invalid-feedback\">La date de lancement doit être supérieur à la date du jour et inférieur à la date de fermeture</div>"
            }else{
                document.getElementById('programmerLancement['+typeticket_id+']').innerHTML=""
            }
        })
    });
    var methodeProgrammationFermetures=document.querySelectorAll("#methodeProgrammationFermeture");
    methodeProgrammationFermetures.forEach(function (methodeProgrammationFermeture) {
        methodeProgrammationFermeture.addEventListener('change',function programmerFermeture() {
            typeticket_id=methodeProgrammationFermeture.getAttribute('data-type-ticket');
            DateVal=$(this).val();
            if(DateVal==="ProgrammerFermeture"){ 
               document.getElementById('programmerFermeture['+typeticket_id+']').innerHTML="<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture["+typeticket_id+"]\" id=\"Date_heure_fermeture\" class=\"form-control\" required min=\"{{now()->format('Y-m-d h:i')}}\" max=\"{{$typeTicket->evenement->date_heure_fin}}\" value=\"{{$typeTicket->Date_heure_fermeture}}\"> <div class=\"invalid-feedback\">La date de lancement doit être supérieur à la date du jour et inférieur à la date de fin de l'évènement</div>";
            }else if(DateVal==="FinEvenement"){
                document.getElementById('programmerFermeture['+typeticket_id+']').innerHTML="<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture["+typeticket_id+"]\" id=\"Date_heure_fermeture\" class=\"form-control\" value=\"{{$typeTicket->evenement->date_heure_fin}}\" required min=\"{{now()->format('Y-m-d h:i')}}\" max=\"{{$typeTicket->evenement->date_heure_fin}}\"> <div class=\"invalid-feedback\">La date de lancement doit être supérieur à la date du jour et inférieur à la date de fin de l'évènement</div>";
            }else{
                document.getElementById('programmerFermeture['+typeticket_id+']').innerHTML="";
            }
        })

     })
     var methodeProgrammationFermetures=document.querySelectorAll("#methodeProgrammationFermeture");
        methodeProgrammationFermetures.forEach(function (methodeProgrammationFermeture) {
        document.addEventListener('DOMContentLoaded',function programmerFermeture() {
            typeticket_id=methodeProgrammationFermeture.getAttribute('data-type-ticket');
            DateVal=$(methodeProgrammationFermeture).val();
    
            
            if(DateVal==="ProgrammerFermeture"){ 
               document.getElementById('programmerFermeture['+typeticket_id+']').innerHTML="<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture["+typeticket_id+"]\" id=\"Date_heure_fermeture\" class=\"form-control\" required min=\"{{now()->format('Y-m-d h:i')}}\" max=\"{{$typeTicket->evenement->date_heure_fin}}\" value=\"{{$typeTicket->Date_heure_fermeture}}\"> <div class=\"invalid-feedback\">La date de lancement doit être supérieur à la date du jour et inférieur à la date de fin de l'évènement</div>";
            }else if(DateVal==="FinEvenement"){
                document.getElementById('programmerFermeture['+typeticket_id+']').innerHTML="<label for=\"Date_heure_fermeture\">Programmer:</label> <input type=\"datetime-local\" name=\"Date_heure_fermeture["+typeticket_id+"]\" id=\"Date_heure_fermeture\" class=\"form-control\" value=\"{{$typeTicket->evenement->date_heure_fin}}\" required min=\"{{now()->format('Y-m-d h:i')}}\" max=\"{{$typeTicket->evenement->date_heure_fin}}\"> <div class=\"invalid-feedback\">La date de lancement doit être supérieur à la date du jour et inférieur à la date de fin de l'évènement</div>";
            }else{
                document.getElementById('programmerFermeture['+typeticket_id+']').innerHTML="";
            }
        })

     })

                
</script>
@endsection