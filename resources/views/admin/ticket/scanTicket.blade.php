@extends('layout.promoteur')
    @section('content')
    <div class="position-relative">
      <div class="toast-container position-absolute top-0 start-50 translate-middle p-3">
          <div id="liveToast" class="toast text-bg-danger" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-body d-flex align-items-center">
                  <div class="p-2">
                      <svg class="bi bi-x-circle" fill="#fff" width="30" height="30">
                          <use xlink:href="#error"></use>
                      </svg>
                  </div>
                  <div class="p-2 fw-bold fs-5">Impossible d'accéder à la caméra </div>
                  <button type="button" class="btn-close  btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
          </div>
      </div>    
  </div>
        <div class="container my-5">
          <div id="QRcodeScanner my-5 p-5">
            <div id="reader" width="600px"></div>
            <div class="row g-3 ">
               <div class="col-12 mt-5 d-flex justify-content-center w-100">
                 <button class="btn btn-success" id="cameraRequest">Scanner code QR</button>
               </div>
            </div>
         </div>
                
        </div>
       
        <div id="evenementAverifier" data-event-id="{{session('evenement_id')}}"></div>
 
  <script>
     var evenementDiv=document.getElementById('evenementAverifier')
      var evenement_Id=evenementDiv.getAttribute('data-event-id')
       
          $('#cameraRequest').on('click', function(e){
            $("#reader").html('');
            $('#cameraRequest').attr('disabled',true);
              Html5Qrcode.getCameras().then(devices => {
               
              /**
               * devices would be an array of objects of type:
               * { id: "id", label: "label" }
               */
              if (devices && devices.length) {
                var cameraId = devices[0].id;
                const html5QrCode = new Html5Qrcode(/* element id */ "reader");
                html5QrCode.start(
                  {facingMode: "environment"}, 
                  {
                    fps: 10,    // Optional, frame per seconds for qr code scanning
                    qrbox: { width: 250, height: 250 }  // Optional, if you want bounded box UI
                  },
                  (decodedText, decodedResult) => {

                    var evenementDiv=document.getElementById('evenementAverifier')
                    var evenement_Id=evenementDiv.getAttribute('data-event-id')
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
                              url: '/verifierTicket',
                              data:JSON.parse(decodedText) ,
                              dataType:'JSON',
                              success: function(response){
                                html5QrCode.stop().then((ignore) => {
                                  $('#cameraRequest').attr('disabled',false);
                                  if (response.qrcodevalidity=='invalid ticket') {
                                  $("#reader").html(`
                                      <div class="w-100 d-flex justify-content-center">
                                        <div>
                                            <div class="circle-border-error"></div>
                                            <div class="circle-error">
                                                <div class="invalid-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                
                                    <div class="w-100 d-flex justify-content-center mt-5">Ticket invalide</div>
                                  `)
                                }
                                 
                                if (response.qrcodevalidity=='valid') {
                                 
                                  $("#reader").html(`
                                    <div class="success-checkmark">
                                        <div class="check-icon">
                                        <span class="icon-line line-tip"></span>
                                        <span class="icon-line line-long"></span>
                                        <div class="icon-circle"></div>
                                        <div class="icon-fix"></div>
                                        </div>
                                    </div>
                                
                                    <div class="w-100 d-flex justify-content-center">Ticket valide</div>
                                  `)
                                
                                }
                                if (response.qrcodevalidity=='verifiedTicket') {
                                  $("#reader").html(`
                                    <div class="f-modal-alert">
                                        <div class="f-modal-icon f-modal-warning scaleWarning">
                                            <span class="f-modal-body pulseWarningIns"></span>
                                            <span class="f-modal-dot pulseWarningIns"></span>
                                        </div>
                                    </div>    
                                
                                    <div class="w-100 d-flex justify-content-center">Ticket déjà vérifié</div>
                                  `)
                                }
                              }).catch((err) => {
                                // Stop failed, handle it.
                              });
                               
                              }
                          }
                        )
                  },
                  (errorMessage) => {
                    // parse error, ignore it.
                  })
                .catch((err) => {
                  // Start failed, handle it.
                });
              }
            }).catch(err => {
                const toastLiveExample = document.getElementById('liveToast');
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample);
                toastBootstrap.show()
            });           
          });
         
          // let html5QrcodeScanner = new Html5QrcodeScanner(
          //   "reader",
          //   { fps: 10, qrbox: {width: 250, height: 250} },
          //   /* verbose= */ false);
          // html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
    @endsection