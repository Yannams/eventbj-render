@extends('layout.promoteur')
    @section('content')
        
       

        <select name="historicFilter" id="historicFilter" class="form-select">
            <option value="tout" data-role="tout" data-evenement-id="{{$evenement->id}}">Tout</option>
          @foreach ($controleurs as $controleur)
            <option value="{{$controleur->id}}" data-role="controleur" data-evenement-id="{{$evenement->id}}">{{$controleur->ControleurId}}</option>
          @endforeach
            <option value="{{$evenement->profil_promoteur_id}}" data-role="promoteur" data-evenement-id="{{$evenement->id}}">Moi-même</option>
        </select>
        <div class="table-responsive">
            <table  id="historiqueTable" class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">nom participant</th>
                    <th scope="col">nom controleur</th>
                    <th scope="col">numero controleur</th>
                    <th scope="col">email controleur</th>
                    <th scope="col">Compte controleur</th>
                    <th scope="col">Role</th>
                    <th scope="col">statut</th>
                    <th scope="col">Date control</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($verifications as $key=>$verification )
                    <tr>
                      <th scope="row">{{$key+1}}</th>
                      <td>{{$verification->ticket_id ? $verification->ticket->user->name : ""}}</td>
                      <td>{{$verification->nom_controleur}}</td>
                      <td>{{$verification->num_controleur}}</td>
                      <td>{{$verification->mail_controleur}}</td>
                      <td>{{$verification->controleur_id ? $verification->controleur->ControleurId : ($verification->profil_promoteur_id ? $verification->profil_promoteur->pseudo : "")}}</td>
                      <td>{{$verification->controleur_id ? "Controleur" : ($verification->profil_promoteur_id ? "Promoteur" : "")}}</td>
                      <td> <span class="p-1 rounded {{$verification->statut=="ticket valide" ? "checked-step" :($verification->statut=="ticket invalide"? "unchecked-step":($verification->statut=="ticket vérifié" ? "checking-step":""))}}">{{$verification->statut}}</span></td>
                      <td>{{date("d/m/Y H:i",strtotime($verification->created_at))}}</td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>

       <script>
          $('#historicFilter').on('input',function (e) {
          
            let selectedFilter= $('#historicFilter option:selected')
           if (selectedFilter.data('role')=="controleur") {
             var data= {
                id: $('#historicFilter').val(),
                role: "controleur",
                evenement_id: selectedFilter.data('evenementId')
             }
           }
           if (selectedFilter.data('role')=="promoteur") {
             var data= {
                id: $('#historicFilter').val(),
                role: "promoteur",
                evenement_id: selectedFilter.data('evenementId')
             }
           }
           if (selectedFilter.data('role')=="tout") {
             var data = {
               role:'tout',
               evenement_id: selectedFilter.data('evenementId')
             }
           }
           
            $.ajaxSetup(
                {
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }
            )
              $.ajax(
                {
                    type:'POST',
                    url:'/historicFilter',
                    data: data,
                    dataType:'JSON',
                    beforeSend:function () {
                       $("#historiqueTable tbody").html(`
                          <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                       `)
                    },
                    success:function (response) {
                      $("#historiqueTable tbody").empty();

                      // Vérifier si on a des résultats
                      if (response.length > 0) {
                          $.each(response, function(index, item) {
                              $("#historiqueTable tbody").append(`
                                  <tr>
                                      <th>${index + 1}</th>
                                      <td>${item.participant}</td>
                                      <td>${item.nom_controleur}</td>
                                      <td>${item.num_controleur}</td>
                                      <td>${item.mail_controleur}</td>
                                      <td>${item.compte_controleur}</td>
                                      <td>${item.role}</td>
                                      <td><span class="p-1 rounded ${item.statut=="ticket valide" ? "checked-step" :(item.statut=="ticket invalide"? "unchecked-step":(item.statut=="ticket vérifié" ? "checking-step":""))}">${item.statut}</span></td>
                                      <td>${item.created_at}</td>
                                  </tr>
                              `);
                          });
                      } else {
                          $("#historiqueTable tbody").append('<tr><td colspan="4">Aucun historique trouvé</td></tr>');
                      }

                    }
                })
            
          })
       </script>
    @endsection
