<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Stock</title>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="<?= constant('BASE_URL') ?>public/assets/css/accueil.css">
</head>

<body>
        <!-- NAVBAR -->
        <div class="navbar col-md-12 d-flex justify-content-center">
    <?php include("navigation.php"); ?>
</div>
    <div class="d-flex">
        <!-- MENU À GAUCHE -->
        <div class="menu-container col-md-3">
            <?php include("menu.php"); ?>
        </div>

        <div class="container mt-5 col-md-9">
            <h2 class="text-center mb-4">Détails du Stock</h2>
            <div class="row">
                <?php if (!empty($stocks)): ?>
                    <?php foreach ($stocks as $stock): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="<?= htmlspecialchars($stock['image_url']) ?>" class="card-img-top"
                                     alt="Image de <?= htmlspecialchars($stock['nom_aliment']) ?>">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title"><?= htmlspecialchars($stock['nom_aliment']) ?: 'Nom inconnu' ?></h5>
                                    <p class="card-text">Gain : <?= htmlspecialchars($stock['gain']) ?> %</p>
                                    <p class="card-text">Prix : <?= htmlspecialchars($stock['prix']) ?> €</p>
                                    <p class="card-text">Quantité en stock : <?= htmlspecialchars($stock['quantite_totale']) ?></p>
                                    <div class="mt-auto">
                                        <!-- Place for future actions (like edit, delete) -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center" role="alert">
                            Aucun stock trouvé.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2025 Projet Final. Tous droits réservés.</p>
            <p>Développé avec <span style="color: red;">&#9829;</span> par Lionnel(ETU003140), Faniry (ETU003149)et Valerie(ETU003233)</p>
        </div>
        <?php include("foot.php"); ?>
    </footer>
</body>

</html>
