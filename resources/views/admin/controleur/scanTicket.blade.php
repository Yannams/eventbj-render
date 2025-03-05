@extends('layout.controleur')
    @section('content')
        <div id="reader" width="600px"></div>
               
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
          
          let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false);
          html5QrcodeScanner.render(onScanSuccess, onScanFailure);
          console.log($('#html5-qrcode-select-camera'));
</script>
@endsection