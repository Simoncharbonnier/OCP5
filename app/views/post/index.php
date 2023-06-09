<link rel="stylesheet" href="assets/css/posts.css">
<link rel="stylesheet" href="assets/css/card.css">

<?php require_once 'app/views/components/header.php'; ?>

<div class="container">
    <div class="row posts">
        <h1>Tous les articles</h1>
        <div class="col-md-12">
            <div class="row">
                <?php foreach ($posts as $i => $post) : ?>
                    <div class="col-10 col-md-4">
                        <a href="?controller=post&action=detail&id=<?= $post['id'] ?>">
                            <div class="card">
                                <img src="assets/img/post/<?= $post['image'] !== null ? htmlspecialchars($post['image']) : 'default.png' ?>" alt="">
                                <div class="card-infos">
                                    <h3><?= htmlspecialchars($post['title']) ?></h3>
                                    <p><?= htmlspecialchars($post['headline']) ?></p>
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

<?php require_once 'app/views/components/footer.php';
