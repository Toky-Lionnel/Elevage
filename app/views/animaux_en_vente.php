<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
data-assets-path="/template/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </html>
    <title>Marketplace</title>
    <link rel="stylesheet" href="<?= constant('BASE_URL')?>public/assets/css/accueil.css">
</head>

<body>
    <section class="container">
        <h2 class="my-4">Animaux en Vente</h2>
        <div class="row">
            <?php if (!empty($animals)): ?>
                <?php foreach ($animals as $animal): ?>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="<?= htmlspecialchars($animal['image_animal']) ?>" class="card-img-top"
                                alt="Image de <?= htmlspecialchars($animal['nom_animal']) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($animal['nom_animal']) ?: 'Nom inconnu' ?></h5>
                                <p class="card-text">
                                    Type : <?= htmlspecialchars($animal['nom_type']) ?><br>
                                    Poids : <?= htmlspecialchars($animal['poids_initial']) ?> kg<br>
                                    Prix/kg : <?= htmlspecialchars($animal['prix_vente_kg']) ?> €
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucun animal en vente pour le moment.</p>
            <?php endif; ?>
        </div>
    </section>
    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2025 Ton Application. Tous droits réservés.</p>
            <p>Développé avec <span style="color: red;">&#9829;</span> par Lionnel,Valérie et Faniry</p>
        </div>
        <?php include("foot.php"); ?>
    </footer>
</body>

</html>