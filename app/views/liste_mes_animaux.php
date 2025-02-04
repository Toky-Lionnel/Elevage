<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de mes animaux</title>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="<?= constant('BASE_URL') ?>public/assets/css/accueil.css">
</head>

<body>
    <div class="container-fluid mt-5">
        <div class="row">
            <!-- Menu à gauche -->
            <div class="col-md-3">
                <?php include("menu.php"); ?>
            </div>

            <!-- Contenu principal -->
            <div class="col-md-9">
                <h2 class="text-center mb-4">Liste de mes animaux</h2>
                <p class="text-center">Surveillez vos animaux et gérez leur état.</p>

                <!-- Liste des animaux non en vente -->
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php if (!empty($animaux)): ?>
                        <?php foreach ($animaux as $animal): ?>
                            <div class="col">
                                <div class="card h-100 shadow-sm">
                                    <img class="card-img-top" src="<?= htmlspecialchars($animal['image_animal']) ?>"
                                        alt="Image de <?= htmlspecialchars($animal['nom_animal']) ?>">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><?= htmlspecialchars($animal['nom_animal']) ?: 'Nom inconnu' ?></h5>
                                        <p class="card-text">Type : <?= htmlspecialchars($animal['nom_type']) ?></p>
                                        <p class="card-text">Poids : <?= htmlspecialchars($animal['poids_initial']) ?> kg</p>
                                        <p class="card-text">Poids min vente : <?= htmlspecialchars($animal['poids_min_vente']) ?> kg</p>
                                        <p class="card-text">Poids max : <?= htmlspecialchars($animal['poids_maximal']) ?> kg</p>
                                        <p class="card-text">Prix vente/kg : <?= htmlspecialchars($animal['prix_vente_kg']) ?> €</p>

                                        <!-- Vérification de la date de mort -->
                                        <?php if ($animal['date_mort'] === null): ?>
                                            <!-- Si l'animal n'a pas de date de mort, afficher l'option d'ajout -->
                                            <?php if ($animal['auto_vente'] == 1): ?>
                                                <form method="POST" action="<?= constant('BASE_URL') ?>ajouter_date_mort">
                                                    <input type="hidden" name="id_animal" value="<?= $animal['id_animal'] ?>">
                                                    <div class="mb-2">
                                                        <label for="date_mort_<?= $animal['id_animal'] ?>">Date de Mort :</label>
                                                        <input type="date" name="date_mort" id="date_mort_<?= $animal['id_animal'] ?>"
                                                            class="form-control" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-danger w-100">Ajouter Date Mort</button>
                                                </form>
                                            <?php else: ?>
                                                <p class="text-success">Auto-Vente Activée</p>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <p class="text-danger">Date de Mort déjà définie : <?= htmlspecialchars($animal['date_mort']) ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p class="text-center">Aucun animal actuellement hors vente.</p>
                        </div>
                    <?php endif; ?>
                </div>
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
</body>

</html>
