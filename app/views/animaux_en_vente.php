<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
data-assets-path="/template/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Vente</title>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="<?= constant('BASE_URL')?>public/assets/css/accueil.css">
</head>

<body>
    <div class="d-flex">
        <!-- MENU À GAUCHE -->
        <div class="menu-container col-md-3">
            <?php include("menu.php"); ?>
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
                                    <img src="<?= htmlspecialchars($animal['image_animal']) ?>" class="card-img-top"
                                        alt="Image de <?= htmlspecialchars($animal['nom_animal']) ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($animal['nom_animal']) ?: 'Nom inconnu' ?></h5>
                                        <p class="card-text">
                                            Type : <?= htmlspecialchars($animal['nom_type']) ?><br>
                                            Poids : <?= htmlspecialchars($animal['poids_initial']) ?> kg<br>
                                            Prix/kg : <?= htmlspecialchars($animal['prix_vente_kg']) ?> €<br>
                                            <strong>Prix total : <?= number_format($prix_total, 2) ?> €</strong>
                                        </p>
                                        <a href="<?= constant('BASE_URL') ?>animaux/achat/<?= $animal['id_animal'] ?>" class="btn btn-primary">Acheter</a>
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

    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2025 Ton Application. Tous droits réservés.</p>
            <p>Développé avec <span style="color: red;">&#9829;</span> par Lionnel, Valérie et Faniry</p>
        </div>
        <?php include("foot.php"); ?>
    </footer>
</body>

</html>
