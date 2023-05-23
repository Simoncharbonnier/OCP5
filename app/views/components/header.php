<div class="navbar">
    <ul class="navbar-nav">
        <div class="navbar-part"></div>
        <div class="navbar-part left">
            <img class="icon-bars" id="btn-menu-responsive" src="assets/img/icons/bars.svg" alt="">
            <li class="nav-item" controller="home" action="index">
                <a class="nav-link" href="?controller=home&action=index">Accueil</a>
            </li>
            <li class="nav-item" controller="post" action="index">
                <a class="nav-link" href="?controller=post&action=index">Articles</a>
            </li>
            <?php if ($_SESSION['is_logged'] === true && $_SESSION['user_admin'] === 1) : ?>
                <li class="nav-item" controller="comment" action="index">
                    <a class="nav-link" href="?controller=comment&action=index">Commentaires</a>
                </li>
                <li class="nav-item" controller="user" action="index">
                    <a class="nav-link" href="?controller=user&action=index">Utilisateurs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="" data-bs-toggle="modal" data-bs-target="#modal-add-post">Ajouter un article</a>
                </li>
            <?php endif; ?>
        </div>
        <div class="navbar-part right">
            <?php if ($_SESSION['is_logged'] === false) : ?>
                <li class="nav-item" controller="user" action="login" form="login">
                    <a class="nav-link" href="?controller=user&action=login&form=login">Connexion</a>
                </li>
                <li class="nav-item" controller="user" action="login" form="signup">
                    <a class="nav-link" href="?controller=user&action=login&form=signup">Inscription</a>
                </li>
            <?php else : ?>
                <li class="nav-item" controller="user" action="logout">
                    <a class="nav-link" href="?controller=user&action=logout">Déconnexion</a>
                </li>
                <li class="nav-item" controller="user" action="detail">
                    <a class="nav-link" href="?controller=user&action=detail&id=<?= $_SESSION['user_id'] ?>">Profil</a>
                </li>
                <li class="nav-item">
                    <img class="avatar" src="assets/img/user/<?= $_SESSION['user_avatar'] ?>" />
                </li>
            <?php endif; ?>
        </div>
    </ul>
</div>

<?php if ($_SESSION['is_logged'] === true && $_SESSION['user_admin'] === 1) : ?>
    <div class="modal fade modal-xl modal-fullscreen-md-down" id="modal-add-post" tabindex="-1" aria-labelledby="modal-add-post-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form enctype="multipart/form-data" id="form-add-post" method="POST" action="?controller=post&action=add">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-add-post-label">Ajouter un article</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h1><input type="text" class="no-border-bottom" name="title" placeholder="Le titre de l'article" autocomplete="off" maxlength="128" required></h1>
                        <h2><input type="text" class="no-border-bottom" name="headline" placeholder="Son chapô juste ici !" autocomplete="off" maxlength="255" required></h2>
                        <p><textarea name="content" class="no-border-bottom" rows="7" placeholder="Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magnam quidem ipsum ullam perferendis, voluptatum provident natus, delectus numquam maxime molestias soluta atque autem alias deleniti explicabo ipsam sint aspernatur quaerat dolores eum unde cum eligendi dicta. Soluta, quos at quaerat maxime veniam neque similique quibusdam ipsum quam provident, optio dolorem. Beatae omnis temporibus assumenda ipsa nemo, laboriosam cupiditate deleniti soluta earum qui laborum ducimus. Tempora consectetur dolore reprehenderit maiores sint deleniti tempore! Sit placeat animi, unde atque vel repellat doloribus velit, accusamus exercitationem sed tenetur. Quis ratione autem exercitationem delectus, quae magnam quod placeat consequatur iusto! Mollitia sequi non tempora?" autocomplete="off" required></textarea></p>
                        <div>
                            <img id="modal-add-post-img" src="" alt="">
                            <div id="modal-add-post-btn-img" class="btn">Ajouter une image</div>
                            <div id="modal-add-post-btn-img-cancel" class="btn d-none">Retirer l'image</div>
                            <input id="modal-add-post-img-input" type="file" name="image" accept="image/*" hidden>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-submit" value="Valider">
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once 'app/views/components/notif.php'; ?>
