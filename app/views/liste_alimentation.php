<!-- Striped Rows -->
<div class="card mt-5">
    <h5 class="card-header"> Liste Type Animal </h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Id Alimentation </th>
                    <th> Nom Aliment  </th>
                    <th> Image_url </th>
                    <th> Gain </th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">

                <?php foreach ($allAlim as $alimentation) { ?>
                    <tr>
                        <td> <?= $alimentation['id_alimentation'] ?></td>
                        <td> <?= $alimentation['nom_aliment'] ?> </td>
                        <td> <?= $alimentation['prix_vente_kg'] ?> </td>
                        <td> <?= $alimentation['poids_maximal'] ?> </td>
                        <td> <?= $alimentation['nb_jour_sans_manger'] ?> </td>
                        <td> <?= $alimentation['perte_poids'] ?> </td>
                        <td> <?= $alimentation['nom_aliment'] ?> </td>
                        <td> <?= $alimentation['gain'] ?> </td>
                        <td> <?= $alimentation['quota'] ?> </td>


                        <td>
                            <a href="<?= constant('BASE_URL') ?>al$alimentation/modifier/<?= $alimentation['id_type_animal'] ?>" class="btn btn-outline-info">
                                <i class="bx bx-edit-alt me-1"></i> Modifier
                            </a>
                        </td>
                        
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>

