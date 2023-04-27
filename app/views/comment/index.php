<link rel="stylesheet" href="assets/css/comments.css">
<script src="assets/js/comments.js"></script>

<?php include_once('app/views/components/header.php'); ?>

<div class="container">
  <div class="row comments">
    <h1>Tous les commentaires</h1>
    <div class="col-md-12">
      <?php foreach ($comments as $i => $comment) : ?>
        <div class="row comment" id="comment-<?= $comment['id'] ?>">
          <div class="col-md-1 comment-part">
            <a class="btn-underline" href="?controller=post&action=detail&id=<?= $comment['post_id'] ?>"><?= $comment['post_title'] ?></a>
          </div>
          <div class="col-md-6 comment-part message">
            <p><?= $comment['message'] ?></p>
          </div>
          <div class="col-md-3 comment-part date-created">
            <p>Publié le <?= $comment['created_at'] ?> par <?= $comment['author'] ?></p>
            <img class="avatar" src="assets/img/user/<?= $comment['author_avatar'] ?>" alt="">
          </div>
          <div class="col-md-1 comment-part">
            <a class="btn btn-edit-comment" href="?controller=comment&action=edit&id=<?= $comment['id'] ?>">
              <?= $comment['valid'] ? "Archiver" : "Valider" ?>
            </a>
            <a class="btn btn-cancel-delete-comment" data-comment-id="<?= $comment['id'] ?>">Annuler</a>
          </div>
          <div class="col-md-1 comment-part">
            <img class="icon-delete btn-delete-comment" src="assets/img/icons/delete.svg" alt="" data-comment-id="<?= $comment['id'] ?>">
            <a class="btn btn-valid-delete-comment" href="?controller=comment&action=delete&id=<?= $comment['id'] ?>">Valider</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<?php include_once('app/views/components/footer.php'); ?>
