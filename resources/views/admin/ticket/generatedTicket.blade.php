<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body{
            font-family: 'inter',sans-serif;
            background-color: #d5d5d5;
            padding: 20px;
            justify-content: center;

        }

        .event_cover{
            border-radius: 20px;
            width:50%   ;
        }

        .card{
            background-color: white;
            border-radius: 20px;
            padding: 8px;
            margin-top: 20px;
            width: 50%;
            justify-items: center;
            justify-self: center;
        }
      
    </style>
</head>
<body>
     
    <img src="{{'data:image/jpg;base64,'.base64_encode(file_get_contents(public_path($data->type_ticket->image_ticket)))}}" alt="evenement_cover" class="event_cover" >
    
    <div class="card">
        <h1> {{$data->type_ticket->evenement->nom_evenement}}</h1>
        <label for=""> Date et heure de début :</label> {{date('d/m/Y',strtotime($data->type_ticket->evenement->date_heure_debut))}} à  {{date('h:i',strtotime($data->type_ticket->evenement->date_heure_debut))}} <br>
        <label for=""> Date et heure de fin :</label> {{date('d/m/Y',strtotime($data->type_ticket->evenement->date_heure_fin))}} à  {{date('h:i',strtotime($data->type_ticket->evenement->date_heure_fin))}}
    </div>

    <div class="card">
        <label for="">Ticket: </label>  {{$data->type_ticket->nom_ticket}} <br>
        <label for="">Prix: </label> {{$data->type_ticket->prix_ticket}}
    </div>

    <div class="card">
        <img src="{{'data:image/svg+xml;base64,'.base64_encode(file_get_contents(public_path($data->code_QR)))}}" alt="evenement_cover">
    </div>
</body>
</html>