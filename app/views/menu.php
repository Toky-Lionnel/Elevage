<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/admin/accueil" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="<?= constant('BASE_URL') ?>/public/assets/images/logo.png" alt="Logo" width="70">
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">Farm shop</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->

    <!-- Layouts -->
    <li class="menu-item">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-layout"></i>
        <div data-i18n="Layouts"> Fonctionnalités </div>
      </a>

      <ul class="menu-sub">
        <li class="menu-item">
          <a href="<?= constant('BASE_URL') ?>reset" class="menu-link">
            <div data-i18n="Without menu"> Reset </div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL')?>type/liste" class="menu-link">
            <div data-i18n="Without menu">Modification Type Animal </div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL') ?>depot" class="menu-link">
            <div data-i18n="Without menu"> Depot d'argent </div>
          </a>
        </li>


        <li class="menu-item">
          <a href="<?= constant('BASE_URL') ?>animaux/liste/vente" class="menu-link">
            <div data-i18n="Without menu"> Liste des animaux à vendre</div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL') ?>alimentation/liste" class="menu-link">
            <div data-i18n="Without menu"> Configuration Alimentation </div>
          </a>
        </li>




        <li class="menu-item">
          <a href="<?= constant('BASE_URL') ?>prevision" class="menu-link">
            <div data-i18n="Without menu"> Page de prevision </div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL') ?>liste/stock" class="menu-link">
            <div data-i18n="Without menu"> Liste stocks </div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL') ?>animaux/liste/vente" class="menu-link">
            <div data-i18n="Without menu"> Marketplace </div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL') ?>liste/alimentation" class="menu-link">
            <div data-i18n="Without menu"> Acheter nourritures </div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL') ?>liste/mesanimaux" class="menu-link">
            <div data-i18n="Without menu">Voir la liste de mes animaux </div>
          </a>
        </li>


      </ul>
    </li>

</aside>
<!-- / Menu -->

<i class="bi bi-box-arrow-in-left"></i>