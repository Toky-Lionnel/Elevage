<?php if (isset($navigation)) { ?>
    <div class="row">
        <div class="col-12 mt-5">
            <!-- Titre dynamique -->
            <h2 class="text-center mb-5">
                Gestion <?= $navigation ?>
            </h2>

            <div class="nav-align-top mb-4 w-100">
                <ul class="nav nav-pills mb-3 nav-fill w-100" role="tablist">
                    <li class="nav-item">
                        <a href="/admin/<?= $ajout ?>" class="nav-link w-100" role="tab" aria-controls="navs-pills-justified-add">
                            <i class="tf-icons bx bx-plus"></i> Ajouter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/<?= $liste ?>" class="nav-link w-100" role="tab" aria-controls="navs-pills-justified-list">
                            <i class="tf-icons bx bx-list-ul"></i> Liste
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/admin/<?= $configuration ?>#" class="nav-link w-100" role="tab" aria-controls="navs-pills-justified-config">
                            <i class="tf-icons bx bx-cog"></i> Configuration
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php } ?>