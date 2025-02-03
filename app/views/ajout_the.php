<h1 class="text-center mb-5 mt-5">Ajouter un Nouveau Thé</h1>

<div class="row w-100 justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulaire d'ajout de Thé</h5>
                <small class="text-muted">Gestion des Thés</small>
            </div>
            <div class="card-body">
                <form method="post" action="/admin/ajout_the" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label" for="fullname">Nom du Thé</label>
                        <input type="text" class="form-control" name="nom_the" placeholder="Earl Grey" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="company">Occupation</label>
                        <input type="number" class="form-control" name="occup" step="0.1" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Rendement /m²</label>
                        <input type="number" name="rendement" class="form-control" step="0.1" required />
                    </div>

                    <div class="mb-3">
                        <label for="formFile" class="form-label">Image</label>
                        <input class="form-control" name="images" type="file" id="formFile" required />
                    </div>


                    <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>