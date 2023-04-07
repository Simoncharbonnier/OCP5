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
      <div class="post-content">
        <p><?= $post['content'] ?></p>
      </div>
      <div class="post-date">
        <p>Publié le <?= $post['created_at'] ?></p>
        <?php if ($post['created_at'] !== $post['updated_at']) { ?>
          <p>Dernière mise à jour le <?= $post['updated_at'] ?></p>
        <?php } ?>
      </div>
      <!-- <img src="https://raw.githubusercontent.com/lewagon/fullstack-images/master/uikit/skateboard.jpg" /> -->
    </div>
  </div>
</div>
