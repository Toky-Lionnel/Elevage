<h1 class="text-center mb-5 mt-5"> Modifier un type d'animal </h1>

<div class="row w-100 justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulaire de modification de Gain </h5>
                <small class="text-muted"> Alimentation </small>
            </div>

            <?php foreach ($alimentation as $alim) { ?>
                <div class="card-body">
                    <form method="post" action="<?= constant('BASE_URL')?>alimentation/modifier/<?= $alim['id_alimentation'] ?>">
                        <div class="mb-3">
                            <label class="form-label" for="fullname">Nom Alimentation </label>
                            <input type="text" class="form-control" name="nom" value="<?= $alim['nom_aliment'] ?>" readonly />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="company"> Prix </label>
                            <input type="number" class="form-control" name="prix" step="0.1" value="<?= $alim['prix'] ?>" readonly />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="company"> Gain </label>
                            <input type="number" class="form-control" name="gain" step="0.1" value="<?= $alim['gain'] ?>" required />
                        </div>

                        
                    <?php } ?>


                    <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                    </form>
                </div>
        </div>
    </div>
</div>