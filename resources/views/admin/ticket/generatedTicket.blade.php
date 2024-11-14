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
        }

        .card-container {
            width: 380px; /* Dimension fixe */
            background-color: #d5d5d5;
            padding: 10px;
        }

        .event_cover {
            border-radius: 20px;
            width: 100%;
            height: auto;
        }

        .card-header,
        .card-body,
        .card-footer {
            background-color: white;
            border-radius: 20px;
            padding: 20px;
            width: 100%;
        }

        .card-header {
            border-bottom: 1px dashed #ccc;
            text-align: center;
        }

        .card-body {
            border-bottom: 1px dashed #ccc;
        }

        .info-1, .info-2 {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            align-items: center;
        }

        .producedBy {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body h5 {
            font-weight: 700;
            font-size: 16px;
            margin: 8px 0;
        }
    </style>
</head>
<body>

    <div class="card-container">
        <div class="card-header">
            <img src="{{'data:image/jpg;base64,'.base64_encode(file_get_contents(public_path($data->type_ticket->image_ticket)))}}" alt="evenement_cover" class="event_cover">
            <h1 style="margin-top: 10px; font-size: 22px;">{{$data->type_ticket->evenement->nom_evenement}}</h1>
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
                    <h5>Heure</h5>
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
                <span>Produced by</span> 
                <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('image/WhatsApp_Image_2023-09-01_à_17.16.15-removebg-preview (1).png')))}}" alt="logo" width="80px">        
            </div>
            <img src="{{'data:image/svg+xml;base64,'.base64_encode(file_get_contents(public_path($data->code_QR)))}}" alt="code QR" width="80px">
        </div>
    </div>

</body>
</html>
