@extends('layout.promoteur')
    @section('content')
        <div class="card border-0 mt-4">
            <div class="card-body">
              <div class="row g-3">
                @foreach ($intervenants as $intervenant )
                  <div class="col-2 d-flex flex-column intervenants position-relative" data-intervenant-id="{{$intervenant->id}}">
                    <div class="d-flex justify-content-center " id="" style="width: 100%; height:100%">
                        <div class="position-relative " style="width: 100px; height: 100px">
                          <img src="{{asset($intervenant->photo_intervenant)}}" alt=""  width="100px" height="100px" class="rounded-circle">
                        </div>
                    </div>
                    <div class="w-100 d-flex  flex-column mt-4">
                      <div class="text-center fs-5 fw-bold">{{$intervenant->nom_intervenant}}</div>
                      <div class="text-center fs-6 fst-italic text-secondary">{{$intervenant->Role_intervenant}}</div>
                    </div>
                  </div>
                @endforeach
                <div class="col-2">
                  <button type="button" class="border-0 bg-white"  data-bs-toggle="modal" data-bs-target="#createIntervenant">
                      <div style="width:100px;height:100px;border:dashed #FBAA0A ; color:#FBAA0A" class="rounded-circle d-flex align-items-center justify-content-center">
                          <div>
                              <i class="bi-plus plus fs-1 fw-bold"></i>
                          </div>
                      </div>
                  </button>
                </div>
              </div>
            </div>
            <div class="modal fade" id="createIntervenant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="{{route('Intervenant.store')}}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate >
                        @csrf
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter un intervenant</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <div class="row">
                              <div class="mb-3 col-12 d-flex justify-content-center">
                                  <label for="photo_intervenant" style="@error('profil_container') border:#F0343C @enderror">
                                      <div class="position-relative" id="profil_container" style="width: 100px; height:100px">
                                          <div style="width:100px;height:100px;background-color:gainsboro" class="rounded-circle d-flex align-items-center justify-content-center position-absolute ">
                                              <div>
                                                  <i class="bi-person person fs-1 fw-bold text-white"></i>
                                              </div>
                                          </div>
                                          <div style="width: 30px; height:30px; background-color:#308747; left:71px; top:70px" class="rounded-circle d-flex align-items-center justify-content-center position-absolute" >
                                              <i class="bi-pencil pencil text-white"></i>
                                          </div>
                                      </div>                  
                                     
                                  </label>
                                  <div class="invalid-feedback">
                                    veuillez ajouter une photo 
                                  </div>
                                <input type="file" name="photo_intervenant" id="photo_intervenant" accept=".png,.jpg,.jpeg,.PNG,.JPG,.JPEG" class="d-none" required>
                              </div>
                              <div class="mb-3 col-12">
                                <label for="nom_intervenant" class="col-form-label">Pseudo :</label>
                                <input type="text" name="nom_intervenant" id="nom_intervenant" class="form-control @error('nom_intervenant') is-invalid @enderror" placeholder="ex: DJ Doe" required>
                                <div class="invalid-feedback">
                                    Le nom de l'intervenant est requis 
                                </div>
                              </div>
                              <div class="mb-3 col-12">
                                  <label for="role_intervenant" class="col-form-label">Role :</label>
                                  <input type="text" name="role_intervenant" id="role_intervenant" class="form-control @error('role_intervenant') is-invalid @enderror" placeholder="ex: DJ" required>
                                  <div class="invalid-feedback">
                                    Veuillez ajouter le role de l'intervenant 
                                  </div>
                              </div>
                              <input type="hidden" name="evenement_id" value="{{$evenement_id}}">
                              <input type="hidden" name="promoteur_id" value="{{Auth()->user()->Profil_promoteur->id}}">
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success" id="submitButton">Ajouter</button>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
            <div class="modal fade" id="EditIntervenant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                 <form action="" id="EditIntervenantForm" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                      @csrf
                      @method('PUT')
                      <div id="intervenant_idDiv">

                      </div>
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Modifier l'intervenant</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div id="IntervenantInfo" class="w-100 text-center">
                              <div class="spinner-border " role="status">
                                <span class="visually-hidden">Loading...</span>
                              </div>
                            </div>
                            <input type="hidden" name="evenement_id" value="{{$evenement_id}}">
                            <input type="hidden" name="promoteur_id" value="{{Auth()->user()->Profil_promoteur->id}}">
                        </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                      <button type="submit" class="btn btn-success">Modifier</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="modal fade" id="DeleteIntervenant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Supprimer intervenant</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="" method="POST" id="DeleteIntervenant">
                      @csrf
                      @method('DELETE')
                      <div class="fs-4 fw-bold my-4">
                        Êtes-vous sûre de vouloir Supprimer ?
                      </div>
                      <input type="hidden" name="intervenant_id" id="IntervenantToDelete" value="">
                      
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-danger" id="ConfirmDelete" >Supprimer</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    <script>
      
      $(document).ready(function(){
        $('#photo_intervenant').change(function (event) {
          if (event.target.files && event.target.files[0]) {
            
            var reader = new FileReader();
            // When the file is read, do this
            reader.onload = function(e) {
              // Create an image element
              var profil = `<div style="width:100px;height:100px;background-color:gainsboro" class="rounded-circle d-flex align-items-center justify-content-center position-absolute ">
                              <div>
                                <img src="`+e.target.result+`" alt="" width="100px" height="100px" class="rounded-circle">
                              </div>
                            </div>
                            <div style="width: 30px; height:30px; background-color:#308747; left:71px; top:70px" class="rounded-circle d-flex align-items-center justify-content-center position-absolute" >
                              <i class="bi-pencil pencil text-white"></i>
                            </div>`
              
              $('#profil_container').html(profil);
            }
            reader.readAsDataURL(event.target.files[0]);
          }
        })

        $('#photo_intervenant_edit').change(function (event) {
          if (event.target.files && event.target.files[0]) {
            
            var reader = new FileReader();
            // When the file is read, do this
            reader.onload = function(e) {
              // Create an image element
              var profil = `<div style="width:100px;height:100px;background-color:gainsboro" class="rounded-circle d-flex align-items-center justify-content-center position-absolute ">
                              <div>
                                <img src="`+e.target.result+`" alt="" width="100px" height="100px" class="rounded-circle">
                              </div>
                            </div>
                            <div style="width: 30px; height:30px; background-color:#308747; left:71px; top:70px" class="rounded-circle d-flex align-items-center justify-content-center position-absolute" >
                              <i class="bi-pencil pencil text-white"></i>
                            </div>`
              
              $('#profil_container_edit').html(profil);
            }
            reader.readAsDataURL(event.target.files[0]);
          }
        })
        $('.intervenants').hover(function (event) {
            var intervenant = $(this); // Utilisez `this` pour obtenir l'élément survolé
            var intervenant_id = intervenant.attr('data-intervenant-id');
           
            if (!intervenant.hasClass('buttons-added')) {
                intervenant.addClass('buttons-added');
                var buttonsHtml = '<div class="buttons-intervenant-container position-absolute bottom-100"><button class=" btn rounded-pill  ms-3 editButton" id="editButton"  data-bs-toggle="modal" data-bs-target="#EditIntervenant" data-bs-whatever="'+intervenant_id+'" style="background-color:#FBAA0A; color:white;"><i class="bi-pencil-square pencil-square text-white"></i></button><button class="rounded-pill ms-3 btn " data-bs-whatever="'+intervenant_id+'" id="DeleteButton" data-bs-toggle="modal" data-bs-target="#DeleteIntervenant" style="background-color:#F0343C; color:white;"><i class="bi-trash trash text-white"></i></button></div>';
                intervenant.prepend(buttonsHtml);
            }
        }, function (event) {
            var intervenant = $(this);
            if (intervenant.hasClass('buttons-added')) {
                intervenant.removeClass('buttons-added');
                intervenant.find('.buttons-intervenant-container').remove();
            }
          }
      
      
      );
       
        const EditIntervenant = $('#EditIntervenant');
        if (EditIntervenant.length) {
          EditIntervenant.on('show.bs.modal', function(event) {
            var intervenant_id =$('#editButton').attr('data-bs-whatever');
            var url='{{ route('Intervenant.edit',":Intervenant_Id") }}'
            url = url.replace(':Intervenant_Id', intervenant_id);
            $.ajax({
                type:'GET',
                url: url,
                data:{intervenant_id: intervenant_id},
                dataType:'JSON',
               
                success: function(data) {
                  const profil_container = EditIntervenant.find('#profil_container_edit');
                  const nom_intervenant=EditIntervenant.find('#nom_intervenant_edit')
                  const role_intervenant=EditIntervenant.find('#role_intervenant_edit')
                  const EditIntervenantForm=$(EditIntervenant.find('#EditIntervenantForm'))
                  console.log(EditIntervenantForm);
                  var formToEdit=`
                    <div  class="mb-3 col-12 d-flex justify-content-center">
                          <label for="photo_intervenant_edit">
                              <div class="position-relative" id="profil_container_edit" style="width: 100px; height:100px">
                                  <div style="width:100px;height:100px;background-color:gainsboro" class="rounded-circle d-flex align-items-center justify-content-center position-absolute ">
                                    <div>
                                      <img src="`+data.photo_intervenant+`" alt="" width="100px" height="100px" class="rounded-circle">
                                    </div>  
                                  </div>
                                  <div style="width: 30px; height:30px; background-color:#308747; left:71px; top:70px" class="rounded-circle d-flex align-items-center justify-content-center position-absolute" >
                                      <i class="bi-pencil pencil text-white"></i>
                                  </div>
                              </div>
                          </label>
                          <input type="file" name="photo_intervenant" id="photo_intervenant_edit" accept=".png,.jpg,.jpeg,.PNG,.JPG,.JPEG" class="d-none" >
                          <div class="invalid-feedback">
                            veuillez ajouter une photo 
                          </div>
                      </div>
                      <div class="mb-3 col-12">
                        <label for="nom_intervenant_edit" class="col-form-label">Pseudo :</label>
                        <input type="text" name="nom_intervenant" id="nom_intervenant_edit" class="form-control" placeholder="ex: DJ Doe" value="`+data.nom_intervenant+`" required>
                        <div class="invalid-feedback">
                            Le nom de l'intervenant est requis 
                        </div>
                      </div>
                      <div class="mb-3 col-12">
                          <label for="role_intervenant_edit" class="col-form-label">Role :</label>
                          <input type="text" name="role_intervenant" id="role_intervenant_edit" class="form-control" placeholder="ex: DJ" value="`+data.role_intervenant+`" required>
                          <div class="invalid-feedback">
                            Veuillez ajouter le role de l'intervenant 
                          </div>
                    </div>
                  `;
                      
                  var intervenant_idInput=`<input type="hidden" name="intervenant_id" id="intervenant_idInput" value="`+intervenant_id+`">`;
                  url='{{route('Intervenant.update',["Intervenant"=>":intervenant_id"])}}'
                  url=url.replace(':intervenant_id',intervenant_id)
                  EditIntervenantForm.attr('action',url);
                  $('#intervenant_idDiv').html(intervenant_idInput);
                  $('#IntervenantInfo').removeClass('text-center');
                  $('#IntervenantInfo').html(formToEdit);

                 
                }
              })
          })
        }


        const DeleteIntervenant = $('#DeleteIntervenant');
        if (DeleteIntervenant.length) {
          DeleteIntervenant.on('show.bs.modal', function(event) {
            var intervenant_id =$('#editButton').attr('data-bs-whatever');
            var url='{{ route('Intervenant.destroy',":Intervenant_Id") }}'
            url = url.replace(':Intervenant_Id', intervenant_id);
            const DeleteIntervenantForm=$(DeleteIntervenant.find('#DeleteIntervenant'));
            const DeleteIntervenantInput=$(DeleteIntervenant.find('#IntervenantToDelete'))
            DeleteIntervenantForm.attr('action',url);
            DeleteIntervenantInput.val(intervenant_id);
            DeleteIntervenant.attr('data-intervenant-id', intervenant_id);
            $('#ConfirmDelete').click(function(){
              DeleteIntervenantForm.submit();
            })
          })
        }
        
       


  //       $(document).on('mouseenter', '.editButton', function(event) {
  //           var editButton = $(this);
  //           if (!editButton.hasClass('hoverEdit')) {
  //               editButton.addClass('hoverEdit');
  //               editButton.html('<i class="bi-pencil-square pencil-square text-white"></i> Modifier');
  //           }
  //       }).on('mouseleave', '.editButton', function(event) {
  //           var editButton = $(this);
  //           if (editButton.hasClass('hoverEdit')) {
  //               editButton.removeClass('hoverEdit');
  //               editButton.html('<i class="bi-pencil-square pencil-square text-white"></i>');
  //           }
  //       })
  //       $(document).on('mouseenter', '.DeleteButton', function(event) {
  //           var DeleteButton = $(this);
  //           if (!DeleteButton.hasClass('hoverDelete')) {
  //               DeleteButton.addClass('hoverDelete');
  //               DeleteButton.html('<i class="bi-trash trash text-white"></i> Supprimer');
  //           }
  //       }).on('mouseleave', '.DeleteButton', function(event) {
  //           var DeleteButton = $(this);
  //           if (DeleteButton.hasClass('hoverDelete')) {
  //               DeleteButton.removeClass('hoverDelete');
  //               DeleteButton.html('<i class="bi-trash trash text-white"></i>');
  //           }
  //       })
  });
    
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
    @endsection

