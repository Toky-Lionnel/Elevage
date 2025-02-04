<!-- Striped Rows -->
<div class="card mt-5">
    <h5 class="card-header"> Liste Type Animal </h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Nom Type  </th>
                    <th> Poids min vente </th>
                    <th> Prix vente kg </th>
                    <th> Poids maximal </th>
                    <th> Nb Jour sans manger  </th>
                    <th> % perte poids </th>
                    <th> Alimentation </th>
                    <th> Gain </th>
                    <th> Quota nourriture </th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">

                <?php foreach ($allType as $type) { ?>
                    <tr>
                        <td> <?= $type['nom_type'] ?></td>
                        <td> <?= $type['poids_min_vente'] ?> </td>
                        <td> <?= $type['prix_vente_kg'] ?> </td>
                        <td> <?= $type['poids_maximal'] ?> </td>
                        <td> <?= $type['nb_jour_sans_manger'] ?> </td>
                        <td> <?= $type['perte_poids'] ?> </td>
                        <td> <?= $type['nom_aliment'] ?> </td>
                        <td> <?= $type['gain'] ?> </td>
                        <td> <?= $type['quota'] ?> </td>


                        <td>
                            <a href="<?= constant('BASE_URL') ?>type/modifier/<?= $type['id_type_animal'] ?>" class="btn btn-outline-info">
                                <i class="bx bx-edit-alt me-1"></i> Modifier
                            </a>
                        </td>
                        
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>

