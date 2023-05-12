<link rel="stylesheet" href="assets/css/home.css">
<link rel="stylesheet" href="assets/css/card.css">

<?php include_once('app/views/components/header.php'); ?>

<div class="col-md-12 banner">
  <h1>Simon Charbonnier, le développeur qu'il vous faut !</h1>
</div>
<div id="home-container" class="container">
  <div class="row presentation">
    <div class="col-md-9">
      <div class="presentation-header">
        <h2>Qui suis-je ?</h2>
        <a href="assets/CV.pdf" target="_blank" class="btn">Voir mon CV</a>
      </div>
      <p class="text">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magnam quidem ipsum ullam perferendis, voluptatum provident natus, delectus numquam maxime molestias soluta atque autem alias deleniti explicabo ipsam sint aspernatur quaerat dolores eum unde cum eligendi dicta. Soluta, quos at quaerat maxime veniam neque similique quibusdam ipsum quam provident, optio dolorem. Beatae omnis temporibus assumenda ipsa nemo, laboriosam cupiditate deleniti soluta earum qui laborum ducimus. Tempora consectetur dolore reprehenderit maiores sint deleniti tempore! Sit placeat animi, unde atque vel repellat doloribus velit, accusamus exercitationem sed tenetur. Quis ratione autem exercitationem delectus, quae magnam quod placeat consequatur iusto! Mollitia sequi non tempora?</p>
    </div>
    <div class="col-md-3 img-wrapper">
      <img src="assets/img/photo.jpg" alt="">
    </div>
  </div>
  <?php if ($posts) : ?>
    <div class="row posts">
      <div class="col-md-12">
        <h2>Quelles sont mes récentes réalisations ?</h2>
        <div class="row">
          <?php foreach ($posts as $post) : ?>
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
        <div class="link-all">
          <a href="?controller=post&action=index" class="btn">Voir tous les articles</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <form id="form-contact" class="row" method="POST" action="?controller=home&action=mail">
    <div class="col-md-8">
      <h3>Vous souhaitez me contacter ? C'est par ici !</h3>
      <div class="row">
        <div class="col-md-4">
          <input type="text" name="first_name" placeholder="Prénom" autocomplete="off" required>
        </div>
        <div class="col-md-4">
          <input type="text" name="last_name" placeholder="Nom" autocomplete="off" required>
        </div>
        <div class="col-md-4">
          <input type="email" name="mail" placeholder="Email" autocomplete="off" required>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <textarea name="message" rows="7" placeholder="Message" autocomplete="off" required></textarea>
        </div>
      </div>
      <input type="submit" class="btn btn-submit long-width">
    </div>
  </form>
</div>

<?php include_once('app/views/components/footer.php'); ?>
