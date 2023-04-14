<link rel="stylesheet" href="assets/css/post.css">
<link rel="stylesheet" href="assets/css/card.css">

<div class="container">
  <div class="row post">
    <div class="col-md-12">
      <div class="post-title">
        <h1><?= $post['title'] ?></h1>
      </div>
      <div class="post-headline">
        <h2><?= $post['headline'] ?></h2>
      </div>
      <?php if ($post['image']) : ?>
        <div class="post-image">
          <img src="assets/img/post/<?= $post['image'] ?>" alt="">
        </div>
      <?php endif; ?>
      <div class="post-content">
        <p><?= $post['content'] ?></p>
      </div>
      <div class="post-date">
        <div class="date-updated">
          <?php if ($post['created_at'] !== $post['updated_at']) : ?>
              <p>Dernière mise à jour le <?= $post['updated_at'] ?></p>
          <?php endif; ?>
        </div>
        <div class="date-created">
          <p>Publié le <?= $post['created_at'] ?> par <?= $post['author'] ?></p>
          <img class="avatar" src="assets/img/user/<?= $post['author_avatar'] ?>" alt="">
        </div>
      </div>
    </div>
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
