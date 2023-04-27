<link rel="stylesheet" href="assets/css/post.css">
<link rel="stylesheet" href="assets/css/card.css">
<script src="assets/js/post.js"></script>

<?php include_once('app/views/components/header.php'); ?>

<div class="container">
  <div class="row post">
    <form enctype="multipart/form-data" id="form-edit-post" method="POST" action="?controller=post&action=edit&id=<?= $post['id'] ?>">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-11">
            <div class="post-title">
              <h1><?= $post['title'] ?></h1>
              <h1><input type="text" name="title" value="<?= $post['title'] ?>" autocomplete="off"></h1>
            </div>
          </div>
          <div class="col-md-1 buttons-container">
            <div class="btn" id="btn-edit-post-cancel">Annuler</div>
            <img class="icon-edit" id="btn-edit-post" src="assets/img/icons/edit.svg">
            <img class="icon-delete" id="btn-delete-post" src="assets/img/icons/delete.svg" data-bs-toggle="modal" data-bs-target="#modal-delete-post">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="post-headline">
              <h2><?= $post['headline'] ?></h2>
              <h2><input type="text" name="headline" value="<?= $post['headline'] ?>" autocomplete="off"></h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="post-image">
              <img id="btn-img-delete" class="icon-cross d-none" src="assets/img/icons/cross.svg">
              <img id="post-img" src="<?= $post['image'] ? 'assets/img/post/' . $post['image'] : '' ?>">
              <div id="btn-img-add" class="btn d-none">Ajouter une image</div>
              <div id="btn-img-cancel" class="btn d-none">Annuler</div>
              <input type="file" name="image" accept="image/*" id="image-input" hidden>
              <input type="text" name="image-changed" id="image-changed-input" value="false" hidden>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="post-content">
              <p><?= $post['content'] ?></p>
              <p><textarea name="content" rows="7"><?= $post['content'] ?></textarea></p>
            </div>
          </div>
        </div>
        <div class="row post-date">
          <div class="col-md-4">
            <div class="date-updated">
              <?php if ($post['created_at'] !== $post['updated_at']) : ?>
                  <p>Dernière mise à jour le <?= $post['updated_at'] ?></p>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-md-4 form-submit">
            <input type="submit" class="btn" value="Valider">
          </div>
          <div class="col-md-4">
            <div class="date-created">
              <p>Publié le <?= $post['created_at'] ?> par <?= $post['author'] ?></p>
              <img class="avatar" src="assets/img/user/<?= $post['author_avatar'] ?>" alt="">
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <div class="row comments">
    <div class="col-md-8">
      <div class="comments-title">
        <?php if ($comments) : ?>
          <h3>Commentaires</h3>
        <?php else : ?>
          <h3>Pas encore de commentaires</h3>
        <?php endif; ?>
      </div>
      <div class="comments-list">
        <?php foreach ($comments as $comment) : ?>
          <div class="comment">
            <p><?= $comment['message'] ?></p>
            <div class="date-created">
              <p>Publié le <?= $comment['created_at'] ?> par <?= $comment['author'] ?></p>
              <img class="avatar" src="assets/img/user/<?= $comment['author_avatar'] ?>" alt="">
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="col-md-4">
      <h3>Quel est votre avis ?</h3>
      <form id="form-comment" method="POST" action="?controller=comment&action=add&id=<?= $post['id'] ?>">
        <textarea name="message" rows="7" placeholder="Commentaire"></textarea>
        <input type="submit" class="btn btn-submit" value="Partager">
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-delete-post" tabindex="-1" aria-labelledby="modal-delete-post-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-delete-post-label">Suppression d'un article</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Êtes-vous certain de vouloir supprimer l'article suivant ?</p>
        <p><b><?= $post['title'] ?></b></p>
      </div>
      <div class="modal-footer">
        <p class="btn" data-bs-dismiss="modal">Annuler</p>
        <a class="btn" href="?controller=post&action=delete&id=<?= $post['id'] ?>">Supprimer</a>
      </div>
    </div>
  </div>
</div>

<?php include_once('app/views/components/footer.php'); ?>
