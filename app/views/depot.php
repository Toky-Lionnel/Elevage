    <!-- NAVBAR -->
    <div class="navbar col-md-12 d-flex justify-content-center">
    <?php include("navigation.php"); ?>
</div>

<h1 class="text-center mb-5 mt-5"> Faire un dépôt </h1>

<div class="row w-100 justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Formulaire de dépôt</h5>
                <small class="text-muted">Dépôt</small>
            </div>
            <div class="card-body">
                <div class="alert alert-info text-center">
                    <strong>Argent actuel :</strong> <?= number_format($argent, 2, ',', ' ') ?>
                </div>
                <form method="post" action="<?= constant('BASE_URL')?>depot/">
                    <div class="mb-3">
                        <label class="form-label" for="argent">Montant à déposer</label>
                        <input type="number" name="argent" class="form-control" step="0.1" required />
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</div>
