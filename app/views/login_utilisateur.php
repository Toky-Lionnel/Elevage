<form id="formAuthentication" class="mb-3" action="<?= constant('BASE_URL')?>connexion" method="POST">
  <div class="mb-3">
    <label for="email" class="form-label">Email or Username</label>
    <input type="text" class="form-control" id="email" name="username" placeholder="Enter your email or username" autofocus required/>
  </div>
  <div class="mb-3 form-password-toggle">
    <label for="password" class="form-label"> Password </label>
    <div class="input-group input-group-merge">
      <input type="password" id="password" class="form-control" name="password" placeholder="••••••••" aria-describedby="password" required />
      <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
    </div>
  </div>
  <div class="mb-3">
    <button class="btn btn-primary d-grid w-100" type="submit">Se connecter </button>
  </div>
  <div class="mb-3">
    <a href="<?= constant('BASE_URL')?>inscription" class="btn btn-primary d-grid w-100">S'inscrire </a>
  </div>
</form>
