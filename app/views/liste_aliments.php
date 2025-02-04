<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Aliments</title>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="<?= constant('BASE_URL') ?>public/assets/css/accueil.css">
</head>

<body>
    <div class="d-flex">
        <!-- MENU À GAUCHE -->
        <div class="menu-container col-md-3">
            <?php include("menu.php"); ?>
        </div>

        <!-- CONTENU PRINCIPAL À DROITE -->
        <div class="container mt-5 col-md-9">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?php
                    if ($_GET['error'] == 'argent_insuffisant') {
                        echo "Vous n'avez pas assez d'argent pour effectuer cet achat.";
                    } elseif ($_GET['error'] == 'quantite_invalide') {
                        echo "Veuillez sélectionner une quantité valide.";
                    }
                    ?>
                </div>
            <?php endif; ?>

            <h2 class="text-center mb-4">Achat nourritures</h2>
            <div class="row">
                <?php if (!empty($aliments)): ?>
                    <?php foreach ($aliments as $aliment): ?>
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="<?= htmlspecialchars($aliment['image_url']) ?>" class="card-img-top"
                                    alt="Image de <?= htmlspecialchars($aliment['nom_aliment']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($aliment['nom_aliment']) ?: 'Nom inconnu' ?>
                                    </h5>
                                    <p class="card-text">Gain : <?= htmlspecialchars($aliment['gain']) ?> %</p>

                                    <!-- Conteneur pour les boutons de quantité -->
                                    <div class="d-flex align-items-center mb-3">
                                        <button class="btn btn-secondary"
                                            onclick="adjustQuantity(<?= $aliment['id_alimentation'] ?>, -1)">-</button>
                                        <input type="number" id="quantity-<?= $aliment['id_alimentation'] ?>" value="0" min="0"
                                            class="form-control mx-2" style="width: 60px;" readonly>
                                        <button class="btn btn-secondary"
                                            onclick="adjustQuantity(<?= $aliment['id_alimentation'] ?>, 1)">+</button>
                                    </div>

                                    <a href="<?= constant('BASE_URL') ?>achat/alimentation?id=<?= $aliment['id_alimentation'] ?>&quantity=0"
                                        class="btn btn-primary" id="buy-button-<?= $aliment['id_alimentation'] ?>">Acheter</a>

                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Aucun aliment trouvé.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2025 Ton Application. Tous droits réservés.</p>
            <p>Développé avec <span style="color: red;">&#9829;</span> par Lionnel(ETU003140), Faniry (ETU003149)et Valerie(ETU003233)</p>
        </div>
        <?php include("foot.php"); ?>
    </footer>

    <script>
        function adjustQuantity(id, change) {
            const quantityInput = document.getElementById(`quantity-${id}`);
            let currentValue = parseInt(quantityInput.value);

            currentValue += change;
            if (currentValue < 0) currentValue = 0; // Empêcher les quantités négatives
            quantityInput.value = currentValue;

            // Mettre à jour dynamiquement l'URL avec l'ID et la quantité
            const buyButton = document.getElementById(`buy-button-${id}`);
            const baseUrl = "<?= constant('BASE_URL') ?>achat/alimentation";
            buyButton.href = `${baseUrl}?id=${id}&quantity=${currentValue}`;
        }


    </script>
</body>

</html>