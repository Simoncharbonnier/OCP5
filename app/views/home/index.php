<link rel="stylesheet" href="assets/css/home.css">
<link rel="stylesheet" href="assets/css/card.css">

<?php include_once 'app/views/components/header.php'; ?>

<div class="col-md-12 banner">
    <h1 class="text-center">Simon Charbonnier, le développeur qu'il vous faut !</h1>
</div>
<div id="home-container" class="container">
    <div class="row presentation">
        <div class="col-10 col-md-9">
            <div class="presentation-header">
                <h2>Qui suis-je ?</h2>
                <a href="assets/CV.pdf" target="_blank" class="btn">Voir mon CV</a>
            </div>
            <p class="text">
                Bonsoir, je m'appelle Simon Charbonnier, j'ai 20 ans et je suis développeur web.
                <br>
                Je suis passionné, notamment par le backend, rigoureux, organisé et j'aime le travail bien fait. Mon objectif est d'acquérir
                de l'expérience, découvrir de nouvelles technologies et développer mes compétences (j'ai beaucoup à faire côté front).
                <br>
                Intéressé par toutes sortes de projets, seul, en équipe, sites web (WordPress aussi), APIs, peu importe, n'hésitez pas
                à me contacter si vous avez besoin d'un développeur, ou simplement si vous souhaitez échanger sur quelque sujet que ce soit,
                ça ne vous coûte rien !
                <br>
                Sinon j'aime aussi beaucoup le sport, j'en ai fait toute ma vie jusque là, les jeux vidéos, les voyages, les animaux...
            </p>
        </div>
        <div class="col-10 col-md-3 img-wrapper">
            <img src="assets/img/photo.jpg" alt="">
        </div>
    </div>
    <?php if ($posts) : ?>
        <div class="row posts">
            <div class="col-md-12">
                <h2>Voici les dernières actualités à mon sujet !</h2>
                <div class="row">
                    <?php foreach ($posts as $post) : ?>
                        <div class="col-10 col-md-4">
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
        <div class="col-10 col-md-8">
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

<?php include_once 'app/views/components/footer.php'; ?>
