<link rel="stylesheet" href="assets/css/comments.css">

<div class="container">
  <div class="row comments">
    <h1>Tous les commentaires</h1>
    <div class="col-md-12">
      <?php foreach ($comments as $i => $comment) : ?>
        <div class="row comment">
          <div class="col-md-6 comment-part message">
            <p><?= $comment['message'] ?></p>
          </div>
          <div class="col-md-3 comment-part date-created">
            <p>Publié le <?= $comment['created_at'] ?> par <?= $comment['author'] ?></p>
            <img class="avatar" src="assets/img/user/<?= $comment['author_avatar'] ?>" alt="">
          </div>
          <div class="col-md-1 comment-part">
            <a class="btn-underline" href="?controller=post&action=detail&id=<?= $comment['post_id'] ?>"><?= $comment['post_title'] ?></a>
          </div>
          <div class="col-md-1 comment-part">
            <a class="btn" href="?controller=comment&action=edit&id=<?= $comment['id'] ?>">
              <?= $comment['valid'] ? "Archiver" : "Valider" ?>
            </a>
          </div>
          <div class="col-md-1 comment-part">
            <a class="btn" href="?controller=comment&action=delete&id=<?= $comment['id'] ?>">Supprimer</a>
          </div>
        </div>
        <hr>
      <?php endforeach; ?>
    </div>
  </div>
</div>
