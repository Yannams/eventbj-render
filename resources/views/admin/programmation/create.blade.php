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
            <div class="col ActivityContainer">
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
                        <div class="col-12 col-md-6">
                            <div class="card shadow mb-3 border-0  mt-3 ms-md-5 w-100 ">
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
                                           <button class="btn btn-success editActivity" data-chronogramme-id="{{$chronogramme->id}}" data-heure-debut="{{$chronogramme->heure_debut}}" data-heure-fin="{{$chronogramme->heure_fin}}" data-nom-activite="{{$chronogramme->nom_activite}}" data-date-activity="{{$chronogramme->date_activite}}" data-evenement-id="{{$evenement->id}} ">Modifier</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    @endif
                @endforeach
                <div class="col-12 col-md-6">      
                    <div class="card shadow mb-3 border-0 mt-3 ms-md-5  w-100">
                        <div class="card-body row ActivityPlace ">
                            <div class="col-8 col-md-10 fs-4 fw-bold">Ajouter une activité</div>
                            <div class="col-4 col-md-2">
                                <button class="btn btn-outline-danger addActivity" data-date-activity="{{$currentDate->toDateString()}}" data-evenement-id="{{ $evenement->id }}" data-last-end-time="{{ $lastActivityEndTime }}">
                                    <svg class="bi bi-plus" fill="currentColor" width="30" height="30">
                                        <use xlink:href="#plus"></use>
                                    </svg>
                                </button>
                            </div>
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
                let previousEndTime = '';
                if (lastEndTime) {
                    const [hours, minutes] = lastEndTime.split(':').map(Number);
                    const endTimeDate = new Date();
                    endTimeDate.setHours(0, 0, 0, 0);
                    endTimeDate.setHours(hours);
                    endTimeDate.setMinutes(minutes)
                    previousEndTime=endTimeDate.toTimeString().substring(0, 5);
                    endTimeDate.setMinutes(minutes + 60);
                    newEndTime = endTimeDate.toTimeString().substring(0, 5);
                    
                }
                
                var formHtml = `
                    <form  method="POST" class="needs-validation" id="addActivityForm" novalidate>
                        @csrf
                        <input type="hidden" name="date_activite" value="${date_activite}">
                        <input type="hidden" name="evenement_id" value="${evenement_id}">
                        <div class="row"> 
                            <div class="">
                                <div class="row g-3">
                                    <div class="col-6">
                                        <label for="heure_debut"> Heure début</label>
                                        <input type="time" name="heure_debut" class="form-control  heure_debutInput" value="${previousEndTime ? previousEndTime : ''}" required>
                                    </div>
                                    <div class="col-6">
                                        <label for="heure_fin"> Heure fin</label>
                                        <input type="time" name="heure_fin" class="form-control  heure_finInput" value="${newEndTime ? newEndTime : ''}" required>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <label for="nom_activite"> nom activité</label>
                                        <input type="text" name="nom_activite" class="form-control  activityInput" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-success AddActivityBtn w-100" id="AddActivityBtn">
                                    <i class="bi-check check"></i> Valider
                                </button> 
                            </div>
                        </div>
                    </form>
                `;
                activityPlace.html(formHtml);

                var newCardHtml = `
                    <div class="col-12 col-md-6 ActivityContainer">
                        <div class="card shadow mb-3 border-0 col-8 mt-3 ms-md-5 col-8 w-100" >
                            <div class="card-body row ActivityPlace">
                                <div class="col-8 col-md-10 fs-4 fw-bold">Ajouter une activité</div>
                                <div class="col-4 col-md-2">
                                    <button class="btn btn-outline-danger addActivity" data-date-activity="${date_activite}" data-evenement-id="${evenement_id}" data-last-end-time="${newEndTime}">
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
                const openedAddActivity=$(".AddActivityBtn").closest(".ActivityPlace"); 
                const openedEditActivity=$(".EditActivityBtn").closest(".ActivityPlace"); 
                const editButton = $(this);
                const activityPlace = editButton.closest('.ActivityPlace');
                const chronogrammeId = editButton.data('chronogramme-id');
                const heureDebut = editButton.data('heure-debut');
                const heureFin = editButton.data('heure-fin');
                const nomActivite = editButton.data('nom-activite');
                const dateActivite = editButton.data('date-activite');
                const evenement_id = editButton.data('evenement-id');
               
                
                if (openedAddActivity) {
                    var newCardHtml = `                        
                        <div class="col-8 col-md-10 fs-4 fw-bold">Ajouter une activité</div>
                        <div class="col-4 col-md-2">
                            <button class="btn btn-outline-danger addActivity" data-date-activity="${dateActivite}" data-evenement-id="${evenement_id}" data-last-end-time="${heureFin}">
                                <svg class="bi bi-plus" fill="currentColor" width="30" height="30">
                                    <use xlink:href="#plus"></use>
                                </svg>
                            </button>
                        </div>                   
                    `;
                    openedAddActivity.html(newCardHtml);
            
                }
                if (openedEditActivity) {
                    
                }

                const formHtml = `
                        <input type="hidden" class="chronogrammeToModify" name="chronogramme_id" value="${chronogrammeId}">
                        <input type="hidden" class="DateActivityToModify" name="date_activite" value="${dateActivite}">
                        <div class="row">
                            <div class="">
                                <div class="row">
                                    <div class="col-6">
                                        <label for="heure_debut"> Heure début</label>
                                        <input type="time" name="heure_debut" class="form-control  heure_debutInputModified " value="${heureDebut}" required>
                                     </div>
                                    <div class="col-6">
                                        <label for="heure_fin"> Heure fin</label>
                                        <input type="time" name="heure_fin" class="form-control  heure_finInputModified " value="${heureFin}" required>
                                    </div>
                                    <div class="col-12">
                                        <label for="nom_activite"> nom activité</label>
                                        <input type="text" name="nom_activite" class="form-control  activityInputModified " value="${nomActivite}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-success editActivityBtn w-100">
                                    <i class="bi-check check"></i>Valider
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
                    beforeSend: function () {
                        $('.editActivityBtn').html(`
                            <div class="spinner-border text-light" role="status">
                                    <span class="visually-hidden">Loading...</span>
                            </div>
                        `);

                        $('.addActivity').prop("disabled",true);

                    },
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

                            $(".addActivity").attr('data-last-end-time',data.heure_fin)

                        }

                    },
                    complete: function() {
                        $('.addActivity').prop("disabled",false);
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

            $('#activitiesContainer').on('click', '.AddActivityBtn', function(e) {
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
                    beforeSend: function () {
                        $('#AddActivityBtn').html(`
                            <div class="spinner-border text-light" role="status">
                                    <span class="visually-hidden">Loading...</span>
                            </div>
                        `);

                        $('.addActivity').prop("disabled",true);

                    },
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
                                        <button class="btn btn-success editActivity" data-chronogramme-id="${data.chronogramme_id}" data-heure-debut="${data.heure_debut}" data-nom-activite="${data.nom_activite}">Modifier</button>
                                    </div>
                                 
                                </div>
                            `);

                            $(".addActivity").attr('data-last-end-time',data.heure_fin)
                        }
                    },
                    complete: function() {
                        $('.addActivity').prop("disabled",false);
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

        function disableSubmitButton(form) {
            form.querySelector('#submitButton').disabled = true;
        }
    </script>
@endsection
