<?php require_once 'app/views/components/header.php'; ?>

<div id="error-container" class="container">
    <div class="row">
        <div class="col-md-6">
            <h1>La page recherchée n'existe pas.</h1>
            <p>Veuillez vérifier que l'URL saisie ne contient pas d'erreur.</p>
            <a class="btn" href="<?= PATH ?>?controller=home&action=index">Page d'accueil</a>
        </div>
        <div class="col-md-6">
            <img src="assets/img/error_404.svg" alt="Erreur 404 image">
        </div>
    </div>
</div>

<?php require_once 'app/views/components/footer.php';
