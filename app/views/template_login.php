<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr"
    data-theme="theme-default" data-assets-path="<?= constant('BASE_URL')?>public/assets/template/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title> Login Pages </title>

    <?php include("head.php"); ?>
    <link rel="stylesheet" href="<?= constant('BASE_URL')?>public/assets/css/login_page.css">

</head>

<body>
    <!-- Content -->

    <div class="container-xxl d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="row justify-content-center auth-container">

                <!-- Colonne de l'image -->
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <img src="<?= constant('BASE_URL')?>public/assets/images/logo.jpeg" alt="Login Image" class="img-fluid login-image">
                </div>


                <!-- Colonne du formulaire de connexion -->
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="app-brand justify-content-center">
                                <a href="#" class="app-brand-link gap-2">
                                    <span class="app-brand-logo demo">
                                        <img src="<?= constant('BASE_URL')?>public/assets/images/logo.jpeg" alt="Logo" width="50">
                                    </span>
                                    <span class="app-brand-text demo text-body fw-bolder">Sneat</span>
                                </a>
                            </div>
                            <!-- Fin logo -->

                            <!-- Contenu centré -->
                            <div class="d-flex flex-column align-items-center">
                                <h4 class="mb-4 mt-4">Welcome to Sneat! 👋</h4>
                                <h4 class="mb-4"> <?= $nom ?></h4>
                            
                                <?php session_start();
                                if (isset($_SESSION['connexion'])) { ?>
                                    <div class="mb-3">
                                        <div class="alert alert-<?=$_SESSION['type']?>" role="alert"> <?= $_SESSION['connexion']; ?></div>
                                    </div>
                                <?php } 
                                unset($_SESSION['connexion']); unset($_SESSION['type']);  ?>
                            </div>

                            <?php if (isset($page)) {
                                include $page . '.php';
                            }
                            ?>
                        </div>

                    </div>
                </div>
                <!-- Fin Colonne du formulaire de connexion -->


            </div>
        </div>
    </div>
    
    <!-- / Content -->

    <?php include("foot.php"); ?>
</body>

</html>