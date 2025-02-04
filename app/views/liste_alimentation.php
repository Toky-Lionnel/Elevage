<!-- Striped Rows -->
<div class="card mt-5">
    <h5 class="card-header"> Liste Alimentation </h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th> Id Alimentation </th>
                    <th> Nom Aliment </th>
                    <th> Image_url </th>
                    <th> Gain </th>
                    <th> Modifier Gain </th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">

                <?php foreach ($allAlim as $alimentation) { ?>
                    <tr>
                        <td> <?= $alimentation['id_alimentation'] ?></td>
                        <td> <?= $alimentation['nom_aliment'] ?> </td>
                        <td>
                            <img id="preview-img-3" class="card-img-top image-liste" src="<?= constant('BASE_URL')?><?= $alimentation['image_url'] ?>" alt="Image du Thé" />
                        </td>
                        <td> <?= $alimentation['gain'] ?> </td>
                        <td>
                            <a href="<?= constant('BASE_URL') ?>alimentation/modifier/<?= $alimentation['id_alimentation'] ?>" class="btn btn-outline-info">
                                <i class="bx bx-edit-alt me-1"></i> Modifier
                            </a>
                        </td>

                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>