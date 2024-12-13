<div>
<form action="{{ route('achat.valider')}}" method="post">
                              @csrf
                                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">enregistrement de l'achat'</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <div class="row">
                                                <div class="form-group">
                                                  <label for="montantVerse">montant versé</label>
                                                  <input class="form-control" type="number" name="montantVerse" id="montantVerse" value="{{ Cart::getTotal()}}" required>
                                                </div>
                                                
                                                <div class="form-group">
                                                  <select class="form-control" name="modePaiement" id="" required>
                                                    <option selected disabled> mode de paiement</option>
                                                    @foreach($comptes as $compte)
                                                    <option value="{{$compte->id}}">{{$compte->nom}}</option>
                                                    @endforeach
                                                  </select>
                                                </div>
                                                <div class="form-group">
                                                  <label for="impot">Accepter</label>
                                                  <input type="checkbox" name="impot" id="impot">
                                                </div>
                                              </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
</div>
