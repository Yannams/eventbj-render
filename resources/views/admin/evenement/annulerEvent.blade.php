@extends('layout.promoteur')
    @section('content')
    <form action="{{route('evenement.destroy',$evenement->id)}}" method="post" onsubmit="disableSubmitButton(this)">
        @csrf
        @method('DELETE')
       <div class="card border-0 shadow">
            <div class="card-body">
                <div class="row g-3">
                    <label for="raison">Raison de l'annulation</label>
                    <select name="raison" id="raison" class="form-select @error('raison') is-invalid @enderror">
                        <option value=""></option>
                        <option value="Evènement test ou de démonstration">Evènement test ou de démonstration</option>
                        <option value="Raison indépendante de ma volonté">Raison indépendante de ma volonté</option>
                        <option value="Pas assez de ventes de billets">Pas assez de ventes de billets</option>
                        <option value="Report/réorganisation de l'évènement">Report/réorganisation de l'évènement</option>
                        <option value="Manque de fonctionnalité">Manque de fonctionnalité</option>
                        <option value="Autre">Autres</option>
                    </select>
                    @error('raison')
                        <div class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-danger"data-bs-toggle="modal" data-bs-target="#staticBackdrop">Suivant</button>
                    </div>
                </div>
            </div>
       </div>
       <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              Êtes-vous sûr de vouloir annuler l'évènement 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Abandonner</button>
              <button type="submit"  id="submitButton" class="btn btn-danger">Annuler</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <script>
        function disableSubmitButton(form) {
            form.querySelector('#submitButton').disabled = true;
        }
    </script>
    @endsection