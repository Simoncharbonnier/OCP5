<div class="navbar">
  <ul class="navbar-nav">
    <div class="navbar-part">
      <li class="nav-item active">
        <a class="nav-link" href="?controller=home&action=index">Accueil</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="?controller=post&action=index">Articles</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="" data-bs-toggle="modal" data-bs-target="#modal-add-post">Ajouter</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Commentaires</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Utilisateurs</a>
      </li>
    </div>
    <div class="navbar-part">
      <li class="nav-item">
        <a class="nav-link" href="#">Connexion</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Inscription</a>
      </li>
      <li class="nav-item dropdown">
        <img class="avatar" src="assets/img/user/photo.jpg" />
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Profil</a>
          <a class="dropdown-item" href="#">Paramètres</a>
          <a class="dropdown-item" href="#">Déconnexion</a>
        </div>
      </li>
    </div>
  </ul>
</div>

<div class="modal fade modal-lg" id="modal-add-post" tabindex="-1" aria-labelledby="modal-add-post-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form-add-post" method="POST" action="?controller=post&action=add">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-add-post-label">Ajouter un article</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <input type="text" name="title" placeholder="Titre" autocomplete="off">
          <input type="text" name="headline" placeholder="Chapô" autocomplete="off">
          <textarea name="content" rows="7" placeholder="Contenu"></textarea>
          <input type="file" name="image">
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-submit" value="Ajouter">
        </div>
      </form>
    </div>
  </div>
</div>
