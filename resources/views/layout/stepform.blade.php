
<ul class="row row-cols-5 row-cols-lg-5 row-cols-md-5 nav nav-pills mb-4 mt-5" id="pillNav" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="@if (session('evenement_id')){{route('Create_event')}}@endif" class="d-flex align-items-center justify-content-center  h-100 fw-bold nav-link rounded @if (request()->url()==route('Create_event')) checking-step @elseif(session('evenement_id')) checked-step @else unchecked-step @endif  me-3" dis role="tab" aria-selected="true" >
            <i class="bi bi-1-circle me-md-2"></i> <span class="d-none d-md-flex"> Fréquence  </span>
        </a>
    </li>         
    {{-- <li class="nav-item" role="presentation">
        <a href="@if (session('TypeLieu')) {{route('select_type_lieu')}} @endif"   class="@if(!session('evenement_id')) disabled border-0 text-white @endif d-flex align-items-center justify-content-center h-100 fw-bold nav-link rounded @if (request()->url()==route('select_type_lieu')) checking-step @elseif (session('TypeLieu')) checked-step  @else unchecked-step @endif me-3" role="tab" aria-selected="true" >
            <i class="bi bi-2-circle me-2"></i> Type de lieu  
        </a>
    </li> --}}
    <li class="nav-item" role="presentation">
        @php
            if ((session('evenement_id')!=null))
                $evenement=session('evenement_id');
            
            else 
                $evenement=0
               
        @endphp
       
        <a href="@if (session('evenement_nom')) {{route('evenement.edit',$evenement)}} @endif"   class="@if(!session('evenement_nom')) disabled border-0 text-white @endif d-flex align-items-center justify-content-center h-100 fw-bold nav-link rounded @if (request()->url()==route('evenement.edit',$evenement)) checking-step @elseif (session('evenement_nom')) checked-step  @else unchecked-step @endif me-3" role="tab" aria-selected="true" >
            <i class="bi bi-2-circle me-md-2"></i><span class="d-none d-md-flex"> Détails de l’évènement</span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="@if (session('localisation')) {{route('localisation')}} @endif"  class="@if(!session('localisation')) disabled border-0 text-white @endif d-flex align-items-center justify-content-center h-100 fw-bold nav-link rounded @if (request()->url()==route('localisation')) checking-step @elseif (session('localisation')) checked-step @else unchecked-step @endif me-3" role="tab" aria-selected="true" >
            <i class="bi bi-3-circle me-md-2"></i><span class="d-none d-md-flex"> Localisation  </span>
        </a>
    </li>     
    <li class="nav-item" role="presentation">
        <a href="@if (session('type_ticket')) {{route('type_ticket.create')}} @endif"  class="@if(!session('type_ticket')) disabled border-0 text-white @endif d-flex align-items-center justify-content-center h-100 fw-bold nav-link rounded @if (request()->url()==route('type_ticket.create')) checking-step @elseif (session('type_ticket')) checked-step @else unchecked-step @endif me-3" role="tab" aria-selected="true" >
            <i class="bi bi-4-circle me-md-2"></i><span class="d-none d-md-flex"> Création de ticket </span>
        </a>
    </li>                              
    <li class="nav-item" role="presentation">
        <a href="@if (session('type_ticket'))
            {{route('type_ticket.index')}}
        @endif" class="h-100 d-flex align-items-center justify-content-center fw-bold nav-link rounded @if(!session('type_ticket')) disabled border-0 text-white    @endif  @if (request()->url()==route('type_ticket.index')) checking-step  @else unchecked-step @endif me-3" role="tab" aria-selected="true"  >
            <i class="bi bi-5-circle me-md-2"></i> <span class="d-none d-md-flex">vos tickets</span>
        </a>
    </li> 

    
</ul>
