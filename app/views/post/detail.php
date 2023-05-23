<link rel="stylesheet" href="assets/css/post.css">
<link rel="stylesheet" href="assets/css/card.css">
<script src="assets/js/post.js"></script>

<?php require_once 'app/views/components/header.php'; ?>

<div class="container">
    <div class="row post">
        <form enctype="multipart/form-data" id="form-edit-post" method="POST" action="?controller=post&action=edit&id=<?= $post['id'] ?>">
            <div class="col-10 col-md-12">
                <div class="row">
                    <div class="<?= ($_SESSION['is_logged'] === true && $_SESSION['user_admin'] === 1) ? 'col-9 col-md-11' : 'col-md-12' ?>">
                        <div class="post-title">
                            <h1><?= htmlspecialchars($post['title']) ?></h1>
                            <h1><input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" autocomplete="off" maxlength="128" required></h1>
                        </div>
                    </div>
                    <?php if ($_SESSION['is_logged'] === true && $_SESSION['user_admin'] === 1) : ?>
                        <div class="col-3 col-md-1 buttons-container">
                            <img class="icon-edit" id="btn-edit-post" src="assets/img/icons/edit.svg">
                            <img class="icon-delete" id="btn-delete-post" src="assets/img/icons/delete.svg" data-bs-toggle="modal" data-bs-target="#modal-delete-post">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="post-headline">
                            <h2><?= htmlspecialchars($post['headline']) ?></h2>
                            <h2><input type="text" name="headline" value="<?= htmlspecialchars($post['headline']) ?>" autocomplete="off" maxlength="255" required></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="post-image">
                            <img id="btn-img-delete" class="icon-cross d-none" src="assets/img/icons/cross.svg">
                            <img id="post-img" src="<?= $post['image'] !== null ? 'assets/img/post/' . htmlspecialchars($post['image']) : '' ?>">
                            <div id="btn-img-add" class="btn d-none">Ajouter une image</div>
                            <div id="btn-img-cancel" class="btn d-none">Annuler</div>
                            <input type="file" name="image" accept="image/*" id="image-input" hidden>
                            <input type="text" name="image-changed" id="image-changed-input" value="false" hidden>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="post-content">
                            <p><?= htmlspecialchars($post['content']) ?></p>
                            <p><textarea name="content" rows="7" required><?= htmlspecialchars($post['content']) ?></textarea></p>
                        </div>
                    </div>
                </div>
                <div class="row post-date">
                    <div class="col-md-4">
                        <div class="date-updated">
                            <?php if ($post['created_at'] !== $post['updated_at']) : ?>
                                <p>Dernière mise à jour le <?= $this->formatDate($post['updated_at']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="btn" id="btn-edit-post-cancel">Annuler</div>
                    </div>
                    <div class="col-md-2 form-submit">
                        <input type="submit" class="btn long-width" value="Valider">
                    </div>
                    <div class="col-md-4">
                        <div class="date-created">
                            <p>Publié le <?= $this->formatDate($post['created_at']) ?> par <a class="btn-underline" href="?controller=user&action=detail&id=<?= $post['author_id'] ?>"><?= htmlspecialchars($post['author']) ?></a></p>
                            <img class="avatar" src="assets/img/user/<?= $post['author_avatar'] ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row comments">
        <div class="col-10 col-md-8">
            <div class="comments-title">
                <?php if (empty($comments) === FALSE) : ?>
                    <h3>Commentaires</h3>
                <?php else : ?>
                    <h3>Pas encore de commentaires</h3>
                <?php endif; ?>
            </div>
            <div class="comments-list">
                <?php foreach ($comments as $comment) : ?>
                    <div class="comment row">
                        <div class="col-md-8">
                            <p><?= htmlspecialchars($comment['message']) ?></p>
                        </div>
                        <div class="col-md-4 date-created">
                            <p>Publié le <?= $this->formatDate($comment['created_at']) ?> par <a class="btn-underline" href="?controller=user&action=detail&id=<?= $comment['author_id'] ?>"><?= htmlspecialchars($comment['author']) ?></a></p>
                            <img class="avatar" src="assets/img/user/<?= $comment['author_avatar'] ?>" alt="">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-10 col-md-4">
            <?php if ($_SESSION['is_logged'] === true) : ?>
                <h3>Quel est votre avis ?</h3>
                <form id="form-comment" method="POST" action="?controller=comment&action=add&id=<?= $post['id'] ?>">
                    <textarea name="message" rows="7" placeholder="Commentaire" autocomplete="off" required></textarea>
                    <input type="submit" class="btn btn-submit long-width" value="Partager">
                </form>
            <?php else : ?>
                <p><i>Vous devez vous connecter pour pouvoir commenter cet article.</i></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-delete-post" tabindex="-1" aria-labelledby="modal-delete-post-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-delete-post-label">Suppression d'un article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p>Êtes-vous certain de vouloir supprimer l'article suivant ?</p>
                <p><b><?= htmlspecialchars($post['title']) ?></b></p>
            </div>
            <div class="modal-footer">
                <p class="btn" data-bs-dismiss="modal">Annuler</p>
                <a class="btn" href="?controller=post&action=delete&id=<?= $post['id'] ?>">Supprimer</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'app/views/components/footer.php';
