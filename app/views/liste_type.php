<!-- Striped Rows -->
<div class="card">
    <h5 class="card-header">Striped rows</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Id type animal </th>
                    <th> Nom Type  </th>
                    <th> Poids min vente </th>
                    <th> Prix vente kg </th>
                    <th> Poids maximal </th>
                    <th> Nb Jour sans manger  </th>
                    <th> % perte poids </th>
                    <th> Alimentation </th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">

                <?php foreach ($allType as $type) { ?>
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong> <?= $type['id_type_animal'] ?> </strong></td>
                        <td> <?= $type['nom_type'] ?></td>
                        <td> <?= $type['poids_min_vente'] ?> </td>
                        <td> <?= $type['prix_vente_kg'] ?> </td>
                        <td> <?= $type['nb_jour_sans_manger'] ?> </td>
                        <td> <?= $type['perte_poids'] ?> </td>
                        <td> <?= $type['nom_aliment'] ?> </td>


                        <td>
                            <a href="/type/modifier/<?= $type['id_type_animal'] ?>" class="btn btn-outline-info">
                                <i class="bx bx-edit-alt me-1"></i> Modifier
                            </a>
                        </td>
                        
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer cet élément ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Oui, supprimer</a>
            </div>
        </div>
    </div>
</div>