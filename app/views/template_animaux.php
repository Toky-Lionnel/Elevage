<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <?php include("head.php"); ?>
  <link rel="stylesheet" href="<?= constant('BASE_URL') ?>public/assets/css/accueil.css">
  <title>Liste des animaux</title>
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

        <div class="container-xxl min-vh-100">


          <div class="content-container col-md-9">
            <section class="container">
              <h2 class="my-4">Listes des animaux achetés </h2>
            </section>
          </div>

        </div>
      </div> <!-- Close the content-container div -->


      <div class="card">
        <h5 class="card-header">Light Table head</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Image</th>
                <th>Poids (kg)</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              <?php if (!empty($animaux)): ?>
                <?php foreach ($animaux as $animal): ?>
                  <tr>
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong><?php echo $animal['id_animal']; ?></strong></td>
                    <td><?php echo $animal['nom_animal'] ?: 'Non défini'; ?></td>
                    <td>
                      <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                        <li
                          data-bs-toggle="tooltip"
                          data-popup="tooltip-custom"
                          data-bs-placement="top"
                          class="avatar avatar-xs pull-up"
                          title="<?php echo $animal['nom_animal'] ?: 'Non défini'; ?>">
                          <img src="<?php echo $animal['image_animal']; ?>" alt="Image de l'animal" width="100">
                    </td>
                    <td><span class="badge bg-label-primary me-1"><?php echo $animal['poids_initial']; ?> kg</span></td>
                    <td>
                      <div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                          <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu">
                          <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-1"></i>
                            <form action="<?= constant('BASE_URL') ?>animaux/nourrir/<?php echo $animal['id_animal']; ?>" method="post">
                              <input type="date" name="dateAlimentation" required>
                              <button type="submit">Nourrir</button>
                            </form>
                          </a>
                          <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                            <form action="<?= constant('BASE_URL') ?>animaux/vendre/<?php echo $animal['id_animal']; ?>" method="post">
                              <input type="date" name="dateFin" required>
                              <button type="submit">Mettre en vente</button>
                            </form>
                          </a>
                        </div>
                      </div>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <p>Aucun animal en vente pour le moment.</p>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
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