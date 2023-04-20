<link rel="stylesheet" href="assets/css/post.css">
<link rel="stylesheet" href="assets/css/card.css">

<div class="container">
  <div class="row post">
    <form id="form-edit-post" method="POST" action="?controller=post&action=edit&id=<?= $post['id'] ?>">
      <div class="col-md-12">
        <div class="row">
          <div class="col-md-10">
            <div class="post-title">
              <h1><?= $post['title'] ?></h1>
              <h1><input type="text" name="title" value="<?= $post['title'] ?>" autocomplete="off"></h1>
            </div>
          </div>
          <div class="col-md-2 buttons-container">
            <div class="btn" id="btn-edit-post-cancel">Annuler</div>
            <div class="btn" id="btn-edit-post">Modifier</div>
            <a class="btn" href="?controller=post&action=delete&id=<?= $post['id'] ?>">Supprimer</a>
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
        <?php if ($post['image']) : ?>
          <div class="row">
            <div class="col-md-12">
              <div class="post-image">
                <img src="assets/img/post/<?= $post['image'] ?>" alt="">
              </div>
            </div>
          </div>
        <?php endif; ?>
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
          <hr>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="col-md-4">
      <h3>Quel est votre avis ?</h3>
      <form id="form-comment" method="POST" action="?controller=comment&action=create">
        <textarea name="comment" rows="7" placeholder="Commentaire"></textarea>
        <input type="submit" class="btn btn-submit" value="Partager">
      </form>
    </div>
  </div>
</div>

<script src="assets/js/post.js"></script>
