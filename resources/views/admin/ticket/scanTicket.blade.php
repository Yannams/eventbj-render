@extends('layout.promoteur')
    @section('content')
        {{-- <div id="reader" width="600px"></div> --}}
        <div class="container mt-5">
          <div id="QRcodeScanner mt-5 p-5">
            <div class="row g-3 ">
               <div class="col-12 mt-5 d-flex justify-content-center w-100">
                 <button class="btn btn-success" id="cameraRequest">Scanner code QR</button>
               </div>
               <div class="col-12 d-flex justify-content-center w-100">
                 <button class="btn btn-outline-success">Télecharger une image</button>
               </div>
            </div>
         </div>
                
        </div>
       
        <div id="evenementAverifier" data-event-id="{{session('evenement_id')}}"></div>
 
  <script>
     var evenementDiv=document.getElementById('evenementAverifier')
      var evenement_Id=evenementDiv.getAttribute('data-event-id')
        function onScanSuccess(decodedText, decodedResult) {
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
                         window.location.href=response.redirectTo
                      }
                  }
              )
          }
          
          function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
          }

          $('#cameraRequest').on('click', function(e){
              Html5Qrcode.getCameras().then(devices => {
              /**
               * devices would be an array of objects of type:
               * { id: "id", label: "label" }
               */
              console.log('1');
              if (devices && devices.length) {
                var cameraId = devices[0].id;
                
                
              }
            }).catch(err => {
               console.log(err);
            });
          
          });
         
          // let html5QrcodeScanner = new Html5QrcodeScanner(
          //   "reader",
          //   { fps: 10, qrbox: {width: 250, height: 250} },
          //   /* verbose= */ false);
          // html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
    @endsection