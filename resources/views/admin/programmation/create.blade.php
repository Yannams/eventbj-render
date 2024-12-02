@extends('layout.promoteur')

@section('content')
    @php
        use Carbon\Carbon;
        Carbon::setLocale('fr');
        setlocale(LC_TIME, 'fr_FR.UTF-8');

        $dateDebut = Carbon::parse($evenement->date_heure_debut);
        $dateFin = Carbon::parse($evenement->date_heure_fin);
        $currentDate = $dateDebut->copy();
    @endphp
    <div class="row row-cols-1" id="activitiesContainer">
        @while ($currentDate->lte($dateFin))
            <div class="col ActivityContainer ">
                <div class="badge badge-tool shadow col-4" style="background-color:#ee151e">
                    <span class="fs-3">{{ $currentDate->format('d') }}</span><br>
                    <span>{{ $currentDate->translatedFormat('F') }}</span>
                </div>
                @php
                    $lastActivityEndTime = null;
                @endphp
                @foreach ($chronogrammes as $chronogramme)
                    @if ($chronogramme->date_activite == $currentDate->toDateString())
                        @php
                            $lastActivityEndTime = $chronogramme->heure_fin;
                        @endphp
                        <div class="card shadow mb-3 border-0 col-8 mt-3 ms-5" style="max-width: 540px;">
                            <div class="card-body row ActivityPlace">
                                <div class="row">
                                    <div class="col-8">
                                        <span class="text-secondary fst-italic">De</span>
                                        <span class="text-success fw-bold">{{date('H:i', strtotime( $chronogramme->heure_debut ))}}</span>
                                        <span class="text-secondary fst-italic">à</span>
                                        <span class="text-danger fw-bold">{{date('H:i', strtotime( $chronogramme->heure_fin)) }}</span>
                                        <span class="text-warning fw-bold">{{ $chronogramme->nom_activite }}</span>
                                    </div>
                                    <div class="col-4">
                                       <button class="btn btn-success editActivity" data-chronogramme-id="{{$chronogramme->id}}" data-heure-debut="{{$chronogramme->heure_debut}}" data-heure-fin="{{$chronogramme->heure_fin}}" data-nom-activite="{{$chronogramme->nom_activite}}" data-date-activity="{{$chronogramme->date_activite}}">Modifier</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="card shadow mb-3 border-0 col-8 mt-3 ms-5" style="max-width: 540px;">
                    <div class="card-body row ActivityPlace">
                        <div class="col-10 fs-4 fw-bold">Ajouter une activité</div>
                        <div class="col-2">
                            <button class="btn btn-outline-danger addActivity" data-date-activity="{{$currentDate->toDateString()}}" data-evenement-id="{{ $evenement->id }}" data-last-end-time="{{ $lastActivityEndTime }}">
                                <svg class="bi bi-plus" fill="currentColor" width="30" height="30">
                                    <use xlink:href="#plus"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $currentDate->addDay();
            @endphp
        @endwhile
    </div>

    <script>
        $(document).ready(function() {
            function addActivityToDiv(date_activite, evenement_id, activityPlace, activityContainer, lastEndTime) {
                let newEndTime = '';
                if (lastEndTime) {
                    const [hours, minutes] = lastEndTime.split(':').map(Number);
                    const endTimeDate = new Date();
                    endTimeDate.setHours(hours + 1);
                    endTimeDate.setMinutes(minutes);
                    newEndTime = endTimeDate.toTimeString().substring(0, 5);
                }
                
                var formHtml = `
                    <form action="{{ route('chronogramme.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="date_activite" value="${date_activite}">
                        <input type="hidden" name="evenement_id" value="${evenement_id}">
                        <div class="row"> 
                            <div class="col-10">
                                <div class="input-group">
                                    <input type="time" name="heure_debut" class="form-control w-25 heure_debutInput" value="${lastEndTime ? lastEndTime : ''}" required>
                                    <input type="time" name="heure_fin" class="form-control w-25 heure_finInput" value="${newEndTime ? newEndTime : ''}" required>
                                    <input type="text" name="nom_activite" class="form-control w-50 activityInput" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-success AddActivityBtn" id="AddActivityBtn">
                                    <i class="bi-check check"></i>
                                </button> 
                            </div>
                        </div>
                    </form>
                `;
                activityPlace.html(formHtml);

                var newCardHtml = `
                    <div class="col ActivityContainer">
                        <div class="card shadow mb-3 border-0 col-8 mt-3 ms-5" style="max-width: 540px;">
                            <div class="card-body row ActivityPlace">
                                <div class="col-10 fs-4 fw-bold">Ajouter une activité</div>
                                <div class="col-2">
                                    <button class="btn btn-outline-danger addActivity" data-date-activity="${date_activite}" data-evenement-id="${evenement_id}" data-last-end-time="${lastEndTime}">
                                        <svg class="bi bi-plus" fill="currentColor" width="30" height="30">
                                            <use xlink:href="#plus"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                activityContainer.after(newCardHtml);
            }
            $('#activitiesContainer').on('click', '.editActivity', function(e) {
                e.preventDefault();

                const editButton = $(this);
                const activityPlace = editButton.closest('.ActivityPlace');
                const chronogrammeId = editButton.data('chronogramme-id');
                const heureDebut = editButton.data('heure-debut');
                const heureFin = editButton.data('heure-fin');
                const nomActivite = editButton.data('nom-activite');
                const dateActivite = editButton.data('date-activite');

                const formHtml = `
                    
                        <input type="hidden" class="chronogrammeToModify" name="chronogramme_id" value="${chronogrammeId}">
                        <input type="hidden" class="DateActivityToModify" name="date_activite" value="${dateActivite}">
                        <div class="row row-cols-2">
                            <div class="col-10">
                                <div class="input-group">
                                    <input type="time" name="heure_debut" class="form-control  heure_debutInputModified w-25" value="${heureDebut}" required>
                                    <input type="time" name="heure_fin" class="form-control  heure_finInputModified w-25" value="${heureFin}" required>
                                    <input type="text" name="nom_activite" class="form-control  activityInputModified w-50" value="${nomActivite}" required>
                                </div>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-success editActivityBtn">
                                    <i class="bi-check check"></i>
                                </button> 
                            </div>  
                        </div>
                    </div
                    
                `;
               
                activityPlace.html(formHtml);
            });
           $('#activitiesContainer').on('click', '.editActivityBtn', function(e) {
                e.preventDefault();
                const activityInputModified = $('.activityInputModified');
                const activityPlace = activityInputModified.closest('.ActivityPlace');
                const chronogrammeId= activityPlace.find('input[name="chronogramme_id"]').val();
                const heureDebut = activityPlace.find('.heure_debutInputModified').val();
                const heureFin =  activityPlace.find('.heure_finInputModified').val();
                //const dateActivite = activityInputModified.closest('.DateActivityToModify').val();
                const nomActivite = activityInputModified.val();
                

                if (!heureDebut) {
                    $('.heure_debutInputModified').addClass('is-invalid');
                } else if (!heureFin) {
                    $('.heure_finInputModified').addClass('is-invalid');
                } else if (!nomActivite) {
                    $('.activityInputModified').addClass('is-invalid');
                } else if (heureDebut>heureFin) {
                    $('.heure_debutInputModified').addClass('is-invalid');
                    $('.heure_finInputModified').addClass('is-invalid');
                }else
                {
                    modifierChronogramme(activityPlace, chronogrammeId,nomActivite,heureDebut,heureFin)
                }
                
           })

           function modifierChronogramme(activityPlace,chronogrammeId,nomActivite,heureDebut,heureFin) {
                  
            var url='{{ route('chronogramme.update',":chronogrammeId") }}'
                url = url.replace(':chronogrammeId', chronogrammeId);
               
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: {
                        chronogramme_id: chronogrammeId,
                        nom_activite: nomActivite,
                        heure_debut: heureDebut,
                        heure_fin: heureFin
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.success) {
                            
                            activityPlace.html(`
                                <div class="row">
                                    <div class="col-8 ">
                                        <span class="text-secondary fst-italic">De</span>
                                        <span class="text-success fw-bold">${data.heure_debut}</span>
                                        <span class="text-secondary fst-italic">à</span>
                                        <span class="text-danger fw-bold">${data.heure_fin}</span>
                                        <span class="text-warning fw-bold">${data.nom_activite}</span>
                                    </div>
                                    <div class="col-4">
                                       <button class="btn btn-success editActivity" data-chronogramme-id="${data.chronogramme_id}" data-heure-debut="${data.heure_debut}" data-heure-fin="${data.heure_fin}" data-nom-activite="${data.nom_activite}">Modifier</button>
                                    </div>
                                </div>
                            `);
                        }
                    }
                });
           }

            $('#activitiesContainer').on('click', '.addActivity', function() {
                var addActivity = $(this);
                var activityPlace = addActivity.closest('.ActivityPlace');
                var activityContainer = addActivity.closest('.ActivityContainer');
                var date_activite = addActivity.data('date-activity');
                var evenement_id = addActivity.data('evenement-id');
                var lastEndTime = addActivity.data('last-end-time');
           
                var heureDebutInput = $('.heure_debutInput');
                var heureFinInput = $('.heure_finInput');
                var activityInput = $('.activityInput');
                var indexHeureDebutInput = heureDebutInput.length;
                var indexHeureFinInput = heureFinInput.length;
                var indexActivityInput = activityInput.length;

                var heureDebutInputModified = $('.heure_debutInputModified');
                var heureFinInputModified = $('.heure_finInputModified');
                var activityInputModified = $('.activityInputModified');
                var indexHeureDebutInputModified = heureDebutInputModified.length;
                var indexHeureFinInputModified = heureFinInputModified.length;
                var indexActivityInputModified = activityInputModified.length;


                if (indexHeureDebutInput > 0 || indexHeureFinInput > 0 || indexActivityInput > 0 || indexHeureDebutInputModified > 0 || indexHeureFinInputModified > 0 || indexActivityInputModified > 0) {
                    if (!heureDebutInput.last().val() || !heureFinInput.last().val() || !activityInput.last().val()) {
                        if (!heureDebutInput.last().val()) {
                            heureDebutInput.last().addClass('is-invalid');
                        } else if (!heureFinInput.last().val()) {
                            heureFinInput.last().addClass('is-invalid');
                        } else if (!activityInput.last().val()) {
                            activityInput.last().addClass('is-invalid');
                        }else if (!heureDebutInputModified.last().val()) {
                            heureDebutInputModified.last().addClass('is-invalid');
                        } else if (!heureFinInputModified.last().val()) {
                            heureFinInputModified.last().addClass('is-invalid');
                        } else if (!activityInputModified.last().val()) {
                            activityInputModified.last().addClass('is-invalid');
                        }
                    } else {
                        addActivityToDiv(date_activite, evenement_id, activityPlace, activityContainer, lastEndTime);
                    }
                } else {
                    addActivityToDiv(date_activite, evenement_id, activityPlace, activityContainer, lastEndTime);
                }
            });

            $('#AddActivityBtn').on('click', '.activityInput', function(e) {
                e.preventDefault();
                var activityInput = $(this);
                var activityPlace = activityInput.closest('.ActivityPlace');
                var heure_debut = activityPlace.find('.heure_debutInput').val();
                var heure_fin = activityPlace.find('.heure_finInput').val();
                var date_activite = activityPlace.find('input[name="date_activite"]').val();
                var nom_activite = activityPlace.find('input[name="nom_activite"]').val();
                var evenement_id = activityPlace.find('input[name="evenement_id"]').val();

                if (!heure_debut) {
                    $('.heure_debutInput').addClass('is-invalid');
                } else if (!heure_fin) {
                    $('.heure_finInput').addClass('is-invalid');
                } else if (!nom_activite) {
                    $('.activityInput').addClass('is-invalid');
                } else if (heure_debut>heure_fin) {
                    $('.heure_debutInput').addClass('is-invalid');
                    $('.heure_finInput').addClass('is-invalid');
                }else {
                    addChronogramme(activityPlace, heure_debut, heure_fin, date_activite, nom_activite, evenement_id, activityInput);
                }
            });

            function addChronogramme(activityPlace, heure_debut, heure_fin, date_activite, nom_activite, evenement_id, activityInput) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route('chronogramme.store') }}',
                    data: {
                        evenement_id: evenement_id,
                        date_activite: date_activite,
                        nom_activite: nom_activite,
                        heure_debut: heure_debut,
                        heure_fin: heure_fin
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.success) {
                            
                            activityPlace.html(`
                                <div class="row">
                                    <div class="col-8 ">
                                        <span class="text-secondary fst-italic">De</span>
                                        <span class="text-success fw-bold">${data.heure_debut}</span>
                                        <span class="text-secondary fst-italic">à</span>
                                        <span class="text-danger fw-bold">${data.heure_fin}</span>
                                        <span class="text-warning fw-bold">${data.nom_activite}</span>
                                    </div>
                                 
                                    <div class="col-4">
                                        <button class="btn btn-success editActivity" data-chronogramme-id="${data.heure_debut}" data-heure-debut="${data.heure_debut}" data-nom-activite="${data.nom_activite}">Modifier</button>
                                    </div>
                                 
                                </div>
                            `);
                        }
                    }
                });
            }

            $('#activitiesContainer').on('change', '.is-invalid', function() {
                    $(this).removeClass('is-invalid').addClass('is-valid');
                    if ($('.heure_debutInput').val()<($('.heure_finInput').val())) {
                        $('.heure_debutInput').removeClass('is-invalid').addClass('is-valid')
                        $('.heure_finInput').removeClass('is-invalid').addClass('is-valid')
                    }
            });

            
        });
    </script>
@endsection
