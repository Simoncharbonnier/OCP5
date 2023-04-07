<link rel="stylesheet" href="assets/css/post.css">
<link rel="stylesheet" href="assets/css/card.css">

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="post-title">
        <h1><?= $post['title'] ?></h1>
      </div>
      <div class="post-headline">
        <h2><?= $post['headline'] ?></h2>
      </div>
      <?php if ($post['image']) { ?>
        <div class="post-image">
          <img src="assets/img/post/<?= $post['image'] ?>" alt="">
        </div>
      <?php } ?>
      <div class="post-content">
        <p><?= $post['content'] ?></p>
      </div>
      <div class="post-date">
        <div class="date-updated">
          <?php if ($post['created_at'] !== $post['updated_at']) { ?>
              <p>Dernière mise à jour le <?= $post['updated_at'] ?></p>
          <?php } ?>
        </div>
        <div class="date-created">
          <p>Publié le <?= $post['created_at'] ?> par <?= $post['user']['first_name'] ?></p>
          <img class="avatar" src="assets/img/user/<?= $post['user']['image'] ?>" alt="">
        </div>
      </div>
    </div>
  </div>
</div>
