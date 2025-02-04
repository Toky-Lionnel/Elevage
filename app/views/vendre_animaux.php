<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de mes animaux</title>
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

                <div class="row mt-5">
                    <div class="col-12 text-center">
                        <h2>Liste des Animaux en Vente</h2>
                    </div>
                </div>

                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php foreach ($animals as $animal): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <img class="card-img-top" src="<?= $animal['image_animal'] ?>" alt="<?= $animal['nom_animal'] ?>" />
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= $animal['nom_animal'] ?></h5>
                                    <p class="card-text">Poids initial: <?= $animal['poids_initial'] ?> kg</p>

                                    <form action="<?= constant('BASE_URL') ?>vente/<?= $animal['id_animal'] ?>" method="POST">
                                        <label for="date_vente">Choisir une date de vente :</label>
                                        <input type="date" name="date_vente" required>
                                        <button type="submit" class="btn btn-success w-100 mt-2">Vendre</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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