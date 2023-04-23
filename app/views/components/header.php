<div class="navbar">
  <ul class="navbar-nav">
    <div class="navbar-part">
      <li class="nav-item" controller="home" action="index">
        <a class="nav-link" href="?controller=home&action=index">Accueil</a>
      </li>
      <li class="nav-item" controller="post" action="index">
        <a class="nav-link" href="?controller=post&action=index">Articles</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="" data-bs-toggle="modal" data-bs-target="#modal-add-post">Ajouter</a>
      </li>
      <li class="nav-item" controller="comment" action="index">
        <a class="nav-link" href="?controller=comment&action=index">Commentaires</a>
      </li>
      <li class="nav-item" controller="user" action="index">
        <a class="nav-link" href="#">Utilisateurs</a>
      </li>
    </div>
    <div class="navbar-part">
      <li class="nav-item" controller="user" action="login">
        <a class="nav-link" href="#">Connexion</a>
      </li>
      <li class="nav-item" controller="user" action="signup">
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

<div class="modal fade modal-xl" id="modal-add-post" tabindex="-1" aria-labelledby="modal-add-post-label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form enctype="multipart/form-data" id="form-add-post" method="POST" action="?controller=post&action=add">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-add-post-label">Ajouter un article</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <h1><input type="text" name="title" placeholder="Le titre de votre futur article préféré" autocomplete="off"></h1>
          <h2><input type="text" name="headline" placeholder="Vous pouvez écrire son chapô juste ici !" autocomplete="off"></h2>
          <p><textarea name="content" rows="7" placeholder="Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magnam quidem ipsum ullam perferendis, voluptatum provident natus, delectus numquam maxime molestias soluta atque autem alias deleniti explicabo ipsam sint aspernatur quaerat dolores eum unde cum eligendi dicta. Soluta, quos at quaerat maxime veniam neque similique quibusdam ipsum quam provident, optio dolorem. Beatae omnis temporibus assumenda ipsa nemo, laboriosam cupiditate deleniti soluta earum qui laborum ducimus. Tempora consectetur dolore reprehenderit maiores sint deleniti tempore! Sit placeat animi, unde atque vel repellat doloribus velit, accusamus exercitationem sed tenetur. Quis ratione autem exercitationem delectus, quae magnam quod placeat consequatur iusto! Mollitia sequi non tempora?" autocomplete="off"></textarea></p>
          <input type="file" name="image" accept="image/*">
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-submit" value="Ajouter">
        </div>
      </form>
    </div>
  </div>
</div>
