<link rel="stylesheet" href="assets/css/users.css">
<script src="assets/js/users.js"></script>

<?php include_once('app/views/components/header.php'); ?>

<div class="container">
  <div class="row users">
    <h1>Tous les utilisateurs</h1>
    <div class="col-10 col-md-12">
      <?php foreach ($users as $i => $user) : ?>
        <div class="row user" id="user-<?= $user['id'] ?>">
          <div class="col-md-1 user-part">
            <img class="avatar" src="assets/img/user/<?= $user['avatar'] ?>" />
          </div>
          <div class="col-md-3 user-part">
            <a class="btn-underline" href="?controller=user&action=detail&id=<?= $user['id'] ?>"><?= $user['mail'] ?></a>
          </div>
          <div class="col-5 col-md-2 user-part">
            <p><?= $user['first_name'] ?></p>
          </div>
          <div class="col-5 col-md-2 user-part">
            <p><?= $user['last_name'] ?></p>
          </div>
          <div class="col-md-1 user-part">
            <p><?= $user['admin'] ? "Admin" : "Visiteur" ?></p>
          </div>
          <div class="col-md-1"></div>
          <div class="col-4 col-md-1 user-part dnone-responsive">
            <a class="btn btn-cancel-delete-user" data-user-id="<?= $user['id'] ?>">Annuler</a>
          </div>
          <div class="col-4 col-md-1 user-part">
            <img class="icon-delete btn-delete-user" src="assets/img/icons/delete.svg" alt="" data-user-id="<?= $user['id'] ?>">
            <a class="btn btn-valid-delete-user" href="?controller=user&action=delete&id=<?= $user['id'] ?>">Valider</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php include_once('app/views/components/footer.php'); ?>
