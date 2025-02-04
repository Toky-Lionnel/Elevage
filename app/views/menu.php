<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="/admin/accueil" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="/assets/images/logo.jpeg" alt="Logo" width="50">
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span>
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
          <a href="<?= constant('BASE_URL')?>type/liste" class="menu-link">
            <div data-i18n="Without menu">Modification Type Animal </div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL')?>depot" class="menu-link">
            <div data-i18n="Without menu"> Depot d'argent </div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL')?>animaux/liste" class="menu-link">
            <div data-i18n="Without menu"> Les Animaux achetés </div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL')?>animaux/liste/vente" class="menu-link">
            <div data-i18n="Without menu"> Liste des animaux à vendre</div>
          </a>
        </li>

        <li class="menu-item">
          <a href="<?= constant('BASE_URL')?>alimentation/liste" class="menu-link">
            <div data-i18n="Without menu"> Configuration Alimentation </div>
          </a>
        </li>

        


        <li class="menu-item">
          <a href="<?= constant('BASE_URL')?>prevision" class="menu-link">
            <div data-i18n="Without menu"> Page de prevision </div>
          </a>
        </li>


      </ul>
    </li>

</aside>
<!-- / Menu -->

<i class="bi bi-box-arrow-in-left"></i>