<link rel="stylesheet" href="assets/css/user.css">
<script src="assets/js/user.js"></script>

<?php require_once 'app/views/components/header.php'; ?>

<div class="container user">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Profil</h1>
        </div>
    </div>
    <div class="row center">
        <form enctype="multipart/form-data" class="col-10 col-md-10 text-center card" id="form-edit-user" action="?controller=user&action=edit&id=<?= $user['id'] ?>" method="POST">
            <h3 class="margin-bottom">Informations</h3>
            <div class="row margin-bottom">
                <div class="col-6 <?= ($_SESSION['is_logged'] === true && $_SESSION['user_mail'] === $user['mail']) ? 'col-md-2' : 'col-md-3'; ?> flex-center input">
                    <p><?= htmlspecialchars($user['first_name']) ?></p>
                    <p><input type="text" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" autocomplete="off" required></p>
                </div>
                <div class="col-6 <?= ($_SESSION['is_logged'] === true && $_SESSION['user_mail'] === $user['mail']) ? 'col-md-2' : 'col-md-3'; ?> flex-center input">
                    <p><?= htmlspecialchars($user['last_name']) ?></p>
                    <p><input type="text" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" autocomplete="off" required></p>
                </div>
                <div class="<?= ($_SESSION['is_logged'] === true && $_SESSION['user_mail'] === $user['mail']) ? 'col-md-4' : 'col-md-3'; ?> flex-center">
                    <p><?= htmlspecialchars($user['mail']) ?></p>
                </div>
                <div class="<?= ($_SESSION['is_logged'] === true && $_SESSION['user_mail'] === $user['mail']) ? 'col-md-2' : 'col-md-3'; ?> flex-center">
                    <img id="avatar" class="avatar" src="assets/img/user/<?= $user['avatar'] ?>">
                    <img id="btn-delete-avatar" class="icon-delete" src="assets/img/icons/cross.svg" alt="">
                    <input id="avatar-input" type="text" name="avatar" value="<?= $user['avatar'] ?>" hidden required>
                    <input id="file-input" type="file" name="image" accept="image/*" hidden>
                </div>
                <?php if ($_SESSION['is_logged'] === true && $_SESSION['user_mail'] === $user['mail']) : ?>
                    <div class="col-md-2 flex-center">
                        <div class="btn" id="btn-edit-user">Modifier</div>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($_SESSION['is_logged'] === true && $_SESSION['user_mail'] === $user['mail']) : ?>
                <div class="row password-row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <input type="password" name="password" placeholder="Mot de passe" autocomplete="off" required>
                    </div>
                    <div class="col-md-3">
                        <input type="password" name="confirm" placeholder="Confirmation" autocomplete="off" required>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row password-row">
                    <div class="col-md-3">
                        <div class="btn d-none" id="btn-edit-user-cancel">Annuler</div>
                    </div>
                    <div class="col-md-3">
                        <input type="submit" value="Valider" class="btn">
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <?php if ($user['admin'] === 1) : ?>
        <div class="row center">
            <div class="col-10 col-md-10 text-center card">
                <h3 class="margin-bottom">Articles</h3>
                <div class="row">
                    <div class="col-md-12">
                        <?php if (empty($posts) === FALSE) : ?>
                            <div class="row headers margin-bottom">
                                <div class="col-md-3 flex-center">
                                    <p>Titre</p>
                                </div>
                                <div class="col-md-6 flex-center">
                                    <p>Chapô</p>
                                </div>
                                <div class="col-md-3 flex-center">
                                    <p>Date de création</p>
                                </div>
                            </div>
                            <?php foreach ($posts as $post) : ?>
                                <div class="row margin-bottom">
                                    <div class="col-md-3 flex-center">
                                        <a class="text-underline" href="?controller=post&action=detail&id=<?= $post['id'] ?>"><?= htmlspecialchars($post['title']) ?></a>
                                    </div>
                                    <div class="col-md-6 flex-center">
                                        <p><?= htmlspecialchars($post['headline']) ?></p>
                                    </div>
                                    <div class="col-md-3 flex-center">
                                        <p><?= $this->formatDate($post['created_at']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>Aucun article</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="row center">
        <div class="col-10 col-md-10 text-center card">
            <h3 class="margin-bottom">Commentaires</h3>
            <div class="row">
                <div class="col-md-12">
                    <?php if (empty($comments) === FALSE) : ?>
                        <div class="row headers margin-bottom">
                            <div class="col-md-3 flex-center">
                                <p>Titre de l'article</p>
                            </div>
                            <div class="col-md-6 flex-center">
                                <p>Message</p>
                            </div>
                            <div class="col-md-3 flex-center">
                                <p>Date de création</p>
                            </div>
                        </div>
                        <?php foreach ($comments as $comment) : ?>
                            <div class="row margin-bottom">
                                <div class="col-md-3 flex-center">
                                    <a class="text-underline" href="?controller=post&action=detail&id=<?= $comment['post_id'] ?>"><?= htmlspecialchars($comment['post_title']) ?></a>
                                </div>
                                <div class="col-md-6 flex-center">
                                    <p><?= htmlspecialchars($comment['message']) ?></p>
                                </div>
                                <div class="col-md-3 flex-center">
                                    <p><?= $this->formatDate($comment['created_at']) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Aucun commentaire validé</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/components/footer.php';
