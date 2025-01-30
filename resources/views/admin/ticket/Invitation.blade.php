@extends('layout.promoteur')
    @section("content")
        <div class="card border-0 shadow">
            <div class="card-body">
                <div class="d-flex justify-content-end mb-5">
                    <button class="btn btn-success">Ajouter un invité</button>
                </div>
                <div class="responsive-table">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">First</th>
                            <th scope="col">Last</th>
                            <th scope="col">Handle</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                          </tr>
                        </tbody>
                      </table>
                </div>
            </div>    
        </div>  
    @endsection