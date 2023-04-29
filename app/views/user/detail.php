<?php include_once('app/views/components/header.php'); ?>

<div class="container user">
  <div class="row">
    <div class="col-md-6">
      <div class="row">
        <form class="text-center" action="?controller=user&action=edit" method="POST">
          <h1>Mon profil</h1>
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
              <input type="submit" class="btn" value="Valider">
            </div>
          </div>
          <a href="?controller=user&action=login&form=login" class="link">Se connecter</a>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include_once('app/views/components/footer.php'); ?>
