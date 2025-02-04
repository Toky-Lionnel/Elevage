<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="/template/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Vente</title>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="<?= constant('BASE_URL') ?>public/assets/css/accueil.css">
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include("menu.php"); ?>

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->


                <!-- NAVBAR -->
                <div class="navbar col-md-12 d-flex justify-content-center">
                    <?php include("navigation.php"); ?>
                </div>

                <!-- CONTENU PRINCIPAL À DROITE -->
                <div class="content-container col-md-9">
                    <section class="container">
                        <h2 class="my-4">Animaux en Vente</h2>
                        <div class="row">
                            <?php if (!empty($animals)): ?>
                                <?php foreach ($animals as $animal):
                                    // Calcul du prix total
                                    $prix_total = $animal['poids_initial'] * $animal['prix_vente_kg'];
                                ?>
                                    <div class="col-md-4">
                                        <div class="card mb-4">
                                            <img height="200px" width="auto"
                                                src="<?= constant('BASE_URL') ?><?= htmlspecialchars($animal['image_animal']) ?>"
                                                class="card-img-top" alt="Image de <?= htmlspecialchars($animal['nom_animal']) ?>">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <?= htmlspecialchars($animal['nom_animal']) ?: 'Nom inconnu' ?></h5>
                                                <p class="card-text">
                                                    Type : <?= htmlspecialchars($animal['nom_type']) ?><br>
                                                    Poids : <?= htmlspecialchars($animal['poids_initial']) ?> kg<br>
                                                    Prix/kg : <?= htmlspecialchars($animal['prix_vente_kg']) ?> €<br>
                                                    <strong>Prix total : <?= number_format($prix_total, 2) ?> €</strong>
                                                </p>
                                                <form method="POST"
                                                    action="<?= constant('BASE_URL') ?>animaux/achat/<?= $animal['id_animal'] ?>">
                                                    <div class="form-group">
                                                        <label for="auto_vente_<?= $animal['id_animal'] ?>">Auto-Vente :</label>
                                                        <input type="checkbox" name="auto_vente"
                                                            id="auto_vente_<?= $animal['id_animal'] ?>" value="1">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Acheter</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>Aucun animal en vente pour le moment.</p>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2025 Ton Application. Tous droits réservés.</p>
            <p>Développé avec <span style="color: red;">&#9829;</span> par Lionnel(ETU003140), Faniry (ETU003149)et
                Valerie(ETU003233)</p>
        </div>
        <?php include("foot.php"); ?>
    </footer>
</body>

</html>