<!--Nouveau Postit-->
<div class="modal fade" id="modal_nouveau_postit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="nouveau_postit">Nouveau Post-it</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="add_postit">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>

            <div class="modal-body">
                <form id="monForm">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nom du post-IT</label>
                        <input class="form-control" type="text"  name="NOM"  id="NOM"/>


                    </div>
                </form>



            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" form="monForm" class="btn btn-primary form-control"  id="send">Save changes</button>

            </div>

        </div>
    </div>
</div>

<!-- Nouvelle tache-->
<div class="modal fade" id="modal_nouvelle_tache" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content" id = "content_modal_tache">

            <div class="modal-header" id="header_tache">


            </div>

            <div class="modal-body" id="body_tache">

                <div class="container" id="grid">
                    <div class="row">
                        <div class="col-sm" id="checkbox_col">
                        </div>
                        <div class="col-sm-8" id="tache_col">
                        </div>
                        <div class="col-sm" id="date_col">
                        </div>
                    </div>
                </div>


                <form id="monForm2">

                </form>
            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary"">Close</button>
                <button type="submit" class="btn btn-primary form-control"  id="send2">Save changes</button>

            </div>

        </div>
    </div>
</div>