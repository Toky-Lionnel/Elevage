<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="/template/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Ajout Thé - Gestion des Thés</title>
    <?php include("head.php"); ?>
    <link rel="stylesheet" href="<?= constant('BASE_URL')?>public/assets/css/accueil.css">
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <?php include("menu.php"); ?>

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl min-vh-100">

                    <?php if (isset($page)) {
                        include($page . '.php');
                    }
                    ?>

                    <?php if (isset($contenu)) {
                        echo $contenu;
                    }
                    ?>


                    <?php if (!isset($accueil)) { ?>
                        <div class="row w-100 justify-content-center mt-4 mb-5">
                            <div class="col-md-6 col-lg-5 text-center">
                                <a href="<?= constant('BASE_URL') ?>accueil" class="btn btn-outline-secondary">
                                    <i class="tf-icons bx bx-arrow-back"></i> Retour
                                </a>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <!-- End Content wrapper -->

        </div>
    </div>

    <!-- Footer Section -->
    <footer class="footer mt-auto py-3 bg-dark text-white">
        <div class="container text-center">
            <p>&copy; 2025 Projet Final. Tous droits réservés.</p>
            <p>Développé avec <span style="color: red;">&#9829;</span> par Lionnel,Valérie et Faniry</p>
        </div>
    </footer>
    <!-- End Footer Section -->



    <?php include("foot.php"); ?>
</body>

</html>