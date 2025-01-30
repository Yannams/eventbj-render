@extends('layout.promoteur')
    @section('content')
        <div class="card border-0 mt-4">
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                  <div>
                    <h1>Intervenants</h1>
                  </div>
                  <button class="btn btn-success"  data-bs-toggle="modal" data-bs-target="#createIntervenant">Ajouter</button>
              </div>
              <div class="table-responsive">
                <table class="table align-middle">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Nom</th>
                      <th scope="col">role</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($intervenants as $intervenant )
                      <tr>
                        <th scope="row">
                          <img src="{{asset($intervenant->photo_intervenant)}}" alt=""  width="100px" height="100px" class="rounded-circle">
                        </th>
                        <td class="fw-bold">{{$intervenant->nom_intervenant}}</td>
                        <td>{{$intervenant->Role_intervenant}}</td>
                        <td>
                          <button type="button" class="btn btn-success " data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu">
                              <li>
                                <button class=" dropdown-item editButton" id="editButton"  data-bs-toggle="modal" data-bs-target="#EditIntervenant" data-bs-whatever="{{$intervenant->id}}" >
                                  <i class="bi-pencil-square pencil-square "></i> Modifier
                                </button>
                              </li>
                              <li>
                                <button class=" dropdown-item" data-bs-whatever="{{$intervenant->id}}" id="DeleteButton" data-bs-toggle="modal" data-bs-target="#DeleteIntervenant">
                                  <i class="bi-trash trash "></i> supprimer
                                </button>
                              </li>
                          </ul>
                        </td>
                      </tr>
                    @endforeach
                   
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal fade" id="cropAvatarmodal" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Recadrer image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="img-container">
                      <img id="uploadedAvatar" src="https://avatars0.githubusercontent.com/u/3456749">
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Annuler</button>
                      <button type="button" class="btn btn-success" id="crop">Recadrer</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal fade" id="cropAvatarmodalEdit" data-bs-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Recadrer image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="img-container">
                      <img id="uploadedAvatarEdit" src="https://avatars0.githubusercontent.com/u/3456749">
                    </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Annuler</button>
                      <button type="button" class="btn btn-success" id="cropEdit">Recadrer</button>
                  </div>
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
                                  <input type="hidden" name="photo_intervenant_cropped" id="photo_intervenant_cropped">
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
        // $('#photo_intervenant').change(function (event) {
        //   if (event.target.files && event.target.files[0]) {
            
        //     var reader = new FileReader();
        //     // When the file is read, do this
        //     reader.onload = function(e) {
        //       // Create an image element
        //       var profil = `<div style="width:100px;height:100px;background-color:gainsboro" class="rounded-circle d-flex align-items-center justify-content-center position-absolute ">
        //                       <div>
        //                         <img src="`+e.target.result+`" alt="" width="100px" height="100px" class="rounded-circle">
        //                       </div>
        //                     </div>
        //                     <div style="width: 30px; height:30px; background-color:#308747; left:71px; top:70px" class="rounded-circle d-flex align-items-center justify-content-center position-absolute" >
        //                       <i class="bi-pencil pencil text-white"></i>
        //                     </div>`
              
        //       $('#profil_container').html(profil);
        //     }
        //     reader.readAsDataURL(event.target.files[0]);
        //   }
        // // })

        // $('#photo_intervenant_edit').change(function (event) {
        //   if (event.target.files && event.target.files[0]) {
            
        //     var reader = new FileReader();
        //     // When the file is read, do this
        //     reader.onload = function(e) {
        //       // Create an image element
        //       var profil = `<div style="width:100px;height:100px;background-color:gainsboro" class="rounded-circle d-flex align-items-center justify-content-center position-absolute ">
        //                       <div>
        //                         <img src="`+e.target.result+`" alt="" width="100px" height="100px" class="rounded-circle">
        //                       </div>
        //                     </div>
        //                     <div style="width: 30px; height:30px; background-color:#308747; left:71px; top:70px" class="rounded-circle d-flex align-items-center justify-content-center position-absolute" >
        //                       <i class="bi-pencil pencil text-white"></i>
        //                     </div>`
              
        //       $('#profil_container').html(profil);
        //     }
        //     reader.readAsDataURL(event.target.files[0]);
        //   }
        // })
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
          EditIntervenant.on('show.bs.modal', event=> {
            const button = event.relatedTarget
            var intervenant_id =button.getAttribute('data-bs-whatever');
            var url='{{ route('Intervenant.edit',":Intervenant_Id") }}'
            url = url.replace(':Intervenant_Id', intervenant_id);
            $.ajax({
                type:'GET',
                url: url,
                data:{intervenant_id: intervenant_id},
                dataType:'JSON',
                beforeSend:function (params) {
                  formToEdit=`
                    <div class="spinner-border " role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  `
                  $('#IntervenantInfo').removeClass('text-center');
                  $('#IntervenantInfo').addClass('text-center');
                  $('#IntervenantInfo').html(formToEdit);
                },
               
                success: function(data) {
                  const profil_container = EditIntervenant.find('#profil_container_edit');
                  const nom_intervenant=EditIntervenant.find('#nom_intervenant_edit')
                  const role_intervenant=EditIntervenant.find('#role_intervenant_edit')
                  const EditIntervenantForm=$(EditIntervenant.find('#EditIntervenantForm'))
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
                          <input type="hidden" name="photo_intervenant_cropped_edit" id="photo_intervenant_cropped_edit">
                          
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
          DeleteIntervenant.on('show.bs.modal', event => {
            const button = event.relatedTarget
            var intervenant_id =button.getAttribute('data-bs-whatever');
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

        window.addEventListener('DOMContentLoaded', function () {
        var avatar = document.getElementById('profile-img');
        var image = document.getElementById('uploadedAvatar');
        var imageEdit = document.getElementById('uploadedAvatarEdit');
        var input = document.getElementById('photo_intervenant');
        var inputEdit= document.getElementById('photo_intervenant_edit');
        var cropBtn = document.getElementById('crop');
        var cropBtnEdit = document.getElementById('cropEdit');
        var createModal= $('#createIntervenant')
        var EditModal= $('#EditIntervenant')
        var $modal = $('#cropAvatarmodal');
        var $modalEdit = $('#cropAvatarmodalEdit');
        var cropper;

        $('[data-toggle="tooltip"]').tooltip();

        input.addEventListener('change', function (e) {
          var files = e.target.files;
          var done = function (url) {
           
            
            // input.value = '';
           
            image.src = url;
            createModal.modal('hide')
            $modal.modal('show');
          };
          // var reader;
          // var file;
          // var url;

          if (files && files.length > 0) {
            let file = files[0];

              // done(URL.createObjectURL(file));
            // if (URL) {
            // } 
            
            // else if (FileReader) {
              reader = new FileReader();
              reader.onload = function (e) {
                done(reader.result);
              };
              reader.readAsDataURL(file);
            // }
          }
        });
        
        EditModal.change('inputEdit', function (e) {
          var files = e.target.files;
         
          
          var done = function (url) {
            // input.value = '';
          
            imageEdit.src = url;
            EditModal.modal('hide')
            $modalEdit.modal('show');
          };
          // var reader;
          // var file;
          // var url;

          if (files && files.length > 0) {
            let file = files[0];

              // done(URL.createObjectURL(file));
            // if (URL) {
            // } 
            
            // else if (FileReader) {
              reader = new FileReader();
              reader.onload = function (e) {
                done(reader.result);
              };
              reader.readAsDataURL(file);
            // }
          }
        });
        
        

        $modal.on('shown.bs.modal', function () {
          cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
          });
        }).on('hidden.bs.modal', function () {
          cropper.destroy();
          cropper = null;
        });
        $modalEdit.on('shown.bs.modal', function () {
          cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
          });
        }).on('hidden.bs.modal', function () {
          cropper.destroy();
          cropper = null;
        });

        cropBtn.addEventListener('click', function () {
          var canvas;

          $modal.modal('hide');

          if (cropper) {
            canvas = cropper.getCroppedCanvas({
              width: 160,
              height: 160,
            });
            // initialAvatarURL = avatar.src;
            var profil = `<div style="width:100px;height:100px;background-color:gainsboro" class="rounded-circle d-flex align-items-center justify-content-center position-absolute ">
                              <div>
                                <img src="`+canvas.toDataURL()+`" alt="" width="100px" height="100px" class="rounded-circle">
                              </div>
                            </div>
                            <div style="width: 30px; height:30px; background-color:#308747; left:71px; top:70px" class="rounded-circle d-flex align-items-center justify-content-center position-absolute" >
                              <i class="bi-pencil pencil text-white"></i>
                            </div>`;
              
              $('#profil_container').html(profil);
             
          }
         
          cropper.getCroppedCanvas().toBlob((blob) => {
            const reader = new FileReader();

            reader.onloadend = () => {
                // Mettre l'image recadrée en Base64 dans l'input caché
                document.getElementById('photo_intervenant_cropped').value = reader.result;

            };

            reader.readAsDataURL(blob);
        });
        createModal.modal('show')
        });
        
         cropBtnEdit.addEventListener('click', function () {
          var canvas;

          $modalEdit.modal('hide');

          if (cropper) {
            canvas = cropper.getCroppedCanvas({
              width: 160,
              height: 160,
            });
            // initialAvatarURL = avatar.src;
            var profil = `<div style="width:100px;height:100px;background-color:gainsboro" class="rounded-circle d-flex align-items-center justify-content-center position-absolute ">
                              <div>
                                <img src="`+canvas.toDataURL()+`" alt="" width="100px" height="100px" class="rounded-circle">
                              </div>
                            </div>
                            <div style="width: 30px; height:30px; background-color:#308747; left:71px; top:70px" class="rounded-circle d-flex align-items-center justify-content-center position-absolute" >
                              <i class="bi-pencil pencil text-white"></i>
                            </div>`;
              
              $('#profil_container_edit').html(profil);
             
          }
         
          cropper.getCroppedCanvas().toBlob((blob) => {
            const reader = new FileReader();

            reader.onloadend = () => {
                // Mettre l'image recadrée en Base64 dans l'input caché
                document.getElementById('photo_intervenant_cropped_edit').value = reader.result;

            };

            reader.readAsDataURL(blob);
        });
        EditModal.modal('show')
        });
      });
    </script>
    @endsection

