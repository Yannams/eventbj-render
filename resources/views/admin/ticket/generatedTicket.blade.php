<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte d'événement</title>
    <style>
        body {
            font-family: 'inter', sans-serif;
            background-color: #d5d5d5;
            padding: 20px;
            display: flex;
            justify-content: center;
            flex-direction: column;
        }

        .event_cover {
            border-radius: 20px;
            width: 100%;
        }

        .card-header {
            position: relative;
            background-color: white;
            border-radius: 20px 20px 0 0;
            padding: 20px;
            width: 90%;
            border-bottom: dashed;  
            display:flex;    
            flex-direction:column;
            align-items: center
        }

        .card-header::before,
        .card-header::after {
            content: "";
            position: absolute;
            bottom: -20px;
            width: 40px;
            height: 40px;
            background-color: #d5d5d5;
            border-radius: 20px;
            z-index: 2;
        }

        .card-header::before {
            left: -20px;
            
        }

        .card-header::after {
            right: -20px;
        }

        .card-body{
            background-color: white;
            border-radius: 20px;
            padding: 8px;
            width: 90%;
            padding: 20px;
            position:relative;
            z-index:1;
            border-bottom: dashed;
        }

        .card-body::before,
        .card-body::after {
            content: "";
            position: absolute;
            bottom: -20px;
            width: 40px;
            height: 40px;
            background-color: #d5d5d5;
            border-radius: 20px;
            z-index: 2;
        }
        .card-body::before {
            left: -20px;
        }

        .card-body::after {
            right: -20px;
        }
       .card-footer {
            background-color: white;
            border-radius: 20px;
            padding: 8px;
            width: 90%;
            padding: 20px;
            text-align: center;
            display: flex;
            justify-content: space-between;
        }

        .info-1, .info-2{
            display: flex;
           justify-content: space-between;
           margin-bottom:10px;
        }

        .producedBy{
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

    <div class="card-header">
        <img src="{{'data:image/jpg;base64,'.base64_encode(file_get_contents(public_path($data->type_ticket->image_ticket)))}}" alt="evenement_cover" class="event_cover">
        <h1> {{$data->type_ticket->evenement->nom_evenement}}</h1>
    </div> 

    <div class="card-body">
       <div>
            <h5>Localisation</h5>
            <div>{{$data->type_ticket->evenement->localisation}}</div>
       </div>
        <div class="info-1">
            <div>
                <h5>Propriétaire</h5>
                <div>{{$data->user->name}}</div>
            </div> 

            <div>
                <h5>Catégorie du ticket</h5>
                <div>{{$data->type_ticket->nom_ticket}}</div>
            </div> 
        </div>
        <div class="info-2">
            <div>
                <h5>heure</h5>
                <div>{{date('H:i',strtotime($data->type_ticket->evenement->date_heure_debut))}}</div>
            </div>
            <div>
                <h5>Date</h5>
                <div>{{date('d F Y',strtotime($data->type_ticket->evenement->date_heure_debut))}}</div>
            </div> 
        </div>
    </div>

    <div class="card-footer">
        <div class="producedBy">
            <span>produced by</span> <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('image/WhatsApp_Image_2023-09-01_à_17.16.15-removebg-preview (1).png')))}}" alt="logo" width="100px">        
        </div>
        <img src="{{'data:image/svg+xml;base64,'.base64_encode(file_get_contents(public_path($data->code_QR)))}}" alt="code QR">
    </div>

</body>
</html>
