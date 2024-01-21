
<ul class="row row-cols-5 row-cols-lg-5 row-cols-md-5 nav nav-pills mb-4" id="pillNav" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="" class=" fw-bold nav-link rounded @if (request()->url()==route('Create_event')) checking-step @elseif(session('evenement_id')) checked-step @else unchecked-step @endif  me-3" dis role="tab" aria-selected="true" >
            Fréquence  
        </a>
    </li>         
    <li class="nav-item" role="presentation">
        <a href="@if (session('evenement_id')) {{route('select_type_lieu')}} @endif" class=" fw-bold nav-link rounded @if (request()->url()==route('select_type_lieu')) checking-step @elseif (session('TypeLieu')) checked-step  @else unchecked-step @endif me-3" role="tab" aria-selected="true" >
            Type de lieu  
        </a>
    </li>          
    <li class="nav-item" role="presentation">
        @php
            if ((session('evenement_id')!=null))
                $evenement=session('evenement_id');
            
            else 
                $evenement=0
               
        @endphp
       
        <a href="@if (session('evenement_nom')) {{route('evenement.edit',$evenement)}} @endif" class=" fw-bold nav-link rounded @if (request()->url()==route('evenement.edit',$evenement)) checking-step @elseif (session('evenement_nom')) checked-step  @else unchecked-step @endif me-3" role="tab" aria-selected="true" >
            Details de l’évènement
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="@if (session('type_ticket')) {{route('type ticket.create')}} @endif" class=" fw-bold nav-link rounded @if (request()->url()==route('type ticket.create')) checking-step @elseif (session('type_ticket')) checked-step @else unchecked-step @endif me-3" role="tab" aria-selected="true" >
            Création de ticket 
        </a>
    </li>                              
    <li class="nav-item" role="presentation">
        <a href="@if (session('type_ticket'))
            {{route('type ticket.index')}}
        @endif" class=" fw-bold nav-link rounded  @if (request()->url()==route('type ticket.index')) checking-step  @else unchecked-step @endif me-3" role="tab" aria-selected="true" >
            vos tickets
        </a>
    </li> 

    
</ul>
