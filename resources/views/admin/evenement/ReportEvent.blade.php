@extends('layout.promoteur')
    @section('content')
        <div class="card border-0 shadow">
            <div class="card-body">
                <form action="{{route('ExecuteReport')}}" method="post">
                    @csrf
                    <h3 class="fw-bold mb-4">Reporter l'évènement</h3>
                    <input type="hidden" name="evenement_id" value="{{$evenement->id}}">
                    <div class="col-12 mb-4">
                        <label for="date_heure_debut" class="mb-1">Date et heure de début</label>
                        <input type="datetime-local" name="date_heure_debut" id="date_heure_debut" class="form-control @error('date_heure_debut') is-invalid @enderror" value="{{ old('date_heure_debut') ?: $evenement->date_heure_debut}}" >
                        @error('date_heure_debut')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror    
                           
                    </div>
                
                    <div class="col-12 mb-4">
                        <label for="date_heure_fin" class="mb-1">Date et heure de fin</label>
                        <input type="datetime-local" name="date_heure_fin" id="date_heure_fin" class="form-control @error('date_heure_fin') is-invalid @enderror" value="{{old('date_heure_fin') ?: $evenement->date_heure_fin}}" >
                        @error('date_heure_fin')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>
                        @enderror 
                    </div>
                    <div class="d-flex justify-content-end">

                        <a href="{{route('MesEvenements')}}" class="btn btn-secondary me-2">Annuler</a>
                        <button type="submit" class="btn btn-success">Reporter</button>
                    </div>
                </form>  
            </div>
        </div>
    @endsection