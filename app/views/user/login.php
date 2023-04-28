<link rel="stylesheet" href="assets/css/login.css">
<script src="assets/js/login.js"></script>

<?php include_once('app/views/components/header.php'); ?>

<div class="container login">
  <div class="row">
    <div class="col-md-4">
      <form id="form-login" class="text-center d-none" action="?controller=user&action=login" method="POST">
        <h1>Connexion</h1>
        <div class="row">
          <div class="col-md-12">
            <input type="text" name="mail" placeholder="Email" autocomplete="off">
          </div>
          <div class="col-md-12">
            <input type="password" name="password" placeholder="Mot de passe" autocomplete="off">
          </div>
          <div class="col-md-12">
            <input type="submit" class="btn" value="Se connecter">
          </div>
        </div>
        <a href="?controller=user&action=login&form=signup" class="link">S'inscrire</a>
      </form>
      <form id="form-signup" class="text-center d-none" action="?controller=user&action=signup" method="POST">
        <h1>Inscription</h1>
        <div class="row">
          <div class="col-md-6">
            <input type="text" name="first_name" placeholder="Prénom" autocomplete="off">
          </div>
          <div class="col-md-6">
            <input type="text" name="last_name" placeholder="Nom" autocomplete="off">
          </div>
          <div class="col-md-12">
            <input type="text" name="mail" placeholder="Email" autocomplete="off">
          </div>
          <div class="col-md-6">
            <input type="password" name="password" placeholder="Mot de passe" autocomplete="off">
          </div>
          <div class="col-md-6">
            <input type="password" name="confirm" placeholder="Confirmation" autocomplete="off">
          </div>
          <div class="col-md-12">
            <input type="submit" class="btn" value="S'inscrire">
          </div>
        </div>
        <a href="?controller=user&action=login&form=login" class="link">Se connecter</a>
      </form>
    </div>
  </div>
</div>

<?php include_once('app/views/components/footer.php'); ?>
