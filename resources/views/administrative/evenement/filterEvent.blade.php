<ul class="row row-cols-6 row-cols-lg-6 row-cols-md-6 nav nav-pills mb-4" id="pillNav" role="tablist">
    <li class="nav-item" role="presentation">
        <a href="{{route('AllEvents')}}" class=" fw-bold nav-link @if (request()->url()==route('AllEvents')) active-filter  @else non-active-filter @endif rounded-1 me-3" dis role="tab" aria-selected="true" >
            Tout  
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a href="{{route('filter_event',['filter'=>true,'filter_character'=>'isOnline'])}}" class=" fw-bold nav-link @if (request()->url()==route('filter_event',['filter'=>true,'filter_character'=>'isOnline'])) active-filter  @else non-active-filter @endif rounded-1  me-3" dis role="tab" aria-selected="true" >
            en ligne  
        </a>
    </li>         
    <li class="nav-item" role="presentation">
        <a href="{{route('filter_event',['filter'=>0,'filter_character'=>'isOnline'])}}" class=" fw-bold nav-link @if (request()->url()==route('filter_event',['filter'=>0,'filter_character'=>'isOnline'])) active-filter  @else non-active-filter @endif rounded-1 me-3" role="tab" aria-selected="true" >
            non-publiés
        </a>
    </li>          
    <li class="nav-item" role="presentation">
        
        <a href="{{route('filter_event',['filter'=>0,'filter_character'=>'administrative_status'])}}" class=" fw-bold nav-link @if (request()->url()==route('filter_event',['filter'=>0,'filter_character'=>'administrative_status'])) active-filter  @else non-active-filter @endif rounded-1 me-3" role="tab" aria-selected="true" >
            Désativés administrativement
        </a>
    </li>

    <li class="nav-item" role="presentation">
        
        <a href="{{route('filter_event',['filter'=>true,'filter_character'=>'recommanded'])}}" class=" fw-bold nav-link @if (request()->url()==route('filter_event',['filter'=>true,'filter_character'=>'recommanded'])) active-filter  @else non-active-filter @endif rounded-1 me-3" role="tab" aria-selected="true" >
            recommandé
        </a>
    </li>

    <li class="nav-item" role="presentation">
        
        <a href="{{route('filter_event',['filter'=>0,'filter_character'=>'recommanded'])}}" class=" fw-bold nav-link @if (request()->url()==route('filter_event',['filter'=>0,'filter_character'=>'recommanded'])) active-filter  @else non-active-filter @endif rounded-1 me-3" role="tab" aria-selected="true" >
           non-recommandé
        </a>
    </li>
   </ul>
