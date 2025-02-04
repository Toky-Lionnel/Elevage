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
                            <input type="text" class="form-control" name="nom" value="<?= $alim['nom_alimentation'] ?>" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="company"> Poids maximal </label>
                            <input type="number" class="form-control" name="poids_max" step="0.1" value="<?= $type['poids_maximal'] ?>" required />
                        </div>

                        <div class="mb-3">
                        <label for="exampleFormControlReadOnlyInput1" class="form-label">Read only</label>
                        <input
                          class="form-control"
                          type="text"
                          id="exampleFormControlReadOnlyInput1"
                          placeholder="Readonly input here..."
                          readonly
                        />
                      </div>

                        <div class="mb-3">
                            <label class="form-label" for="company"> % perte poids </label>
                            <input type="number" class="form-control" name="perte_poids" step="0.1" value="<?= $type['perte_poids'] ?>" required />
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="company"> Quota nourriture </label>
                            <input type="number" class="form-control" name="quota" step="0.1" value="<?= $type['quota'] ?>" required />
                        </div>

                        

                        <div class="mb-3">
                            <label for="defaultSelect" class="form-label"> Alimentation </label>
                            <select id="defaultSelect" name="alimentation" class="form-select">
                                <option value="<?= $type['id_alimentation'] ?>"> <?= $type['nom_aliment'] ?> </option>
                                <?php foreach ($allAlim as $alim) {
                                    if ($alim['id_alimentation'] != $type['id_alimentation']) { ?>
                                        <option value="<?= $alim['id_alimentation'] ?>"><?= $alim['nom_aliment'] ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                    <?php } ?>


                    <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                    </form>
                </div>
        </div>
    </div>
</div>