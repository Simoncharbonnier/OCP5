<link rel="stylesheet" href="assets/css/posts.css">
<link rel="stylesheet" href="assets/css/card.css">

<div class="container">
  <div class="row posts">
    <h1>Tous les articles</h1>
    <div class="col-md-12">
      <div class="row">
        <?php foreach ($posts as $i => $post) : ?>
          <div class="col-md-4">
            <a href="?controller=post&action=detail&id=<?= $post['id'] ?>">
              <div class="card-product">
                <img src="https://raw.githubusercontent.com/lewagon/fullstack-images/master/uikit/skateboard.jpg" />
                <div class="card-product-infos">
                  <h3><?= $post['title'] ?></h3>
                  <p><?= $post['headline'] ?></p>
                </div>
                <div class="card-product-footer">
                  <p><?= $post['updated_at'] ?></p>
                </div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>
