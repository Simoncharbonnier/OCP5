<link rel="stylesheet" href="assets/css/posts.css">
<link rel="stylesheet" href="assets/css/card.css">

<?php include_once('app/views/components/header.php'); ?>

<div class="container">
  <div class="row posts">
    <h1>Tous les articles</h1>
    <div class="col-md-12">
      <div class="row">
        <?php foreach ($posts as $i => $post) : ?>
          <div class="col-md-4">
            <a href="?controller=post&action=detail&id=<?= $post['id'] ?>">
              <div class="card">
                <?php if ($post['image']) : ?>
                  <img src="assets/img/post/<?= $post['image'] ?>" alt="">
                <?php endif; ?>
                <div class="card-infos <?= $post['image'] ? '' : 'no-image' ?>">
                  <h3><?= $post['title'] ?></h3>
                  <p><?= $post['headline'] ?></p>
                </div>
                <div class="card-footer">
                  <p><?= $this->formatDate($post['updated_at']) ?></p>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<?php include_once('app/views/components/footer.php'); ?>
