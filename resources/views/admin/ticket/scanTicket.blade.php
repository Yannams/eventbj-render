@extends('layout.promoteur')
    @section('content')
        <div id="reader" width="600px"></div>
        
 
 
  <script>
        function onScanSuccess(decodedText, decodedResult) {
               
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
                      data:JSON.parse(decodedText),
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
</script>
    @endsection