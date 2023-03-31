<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
  </head>
  <body>
    <?php include('app/views/components/header.php'); ?>
    <div class="container">
      <div class="row col-md-12 banner">
        <h1>Simon Charbonnier, le développeur qu'il vous faut !</h1>
      </div>
      <div class="row col-md-12">
        <h2>Présentation</h2>
        <p>Photo</p>
        <p>Réseaux sociaux</p>
        <p>Lien CV</p>
      </div>
      <div class="row col-md-12">
        <h2>Formulaire de contact</h2>
        <form id="form-contact" action="">
          <input type="text" name="first_name" placeholder="Prénom">
          <input type="text" name="last_name" placeholder="Nom">
          <input type="text" name="mail" placeholder="Email">
          <textarea name="message" cols="30" rows="10" placeholder="Message"></textarea>
          <input type="submit">
        </form>
      </div>
    </div>
    <?php include('app/views/components/footer.php'); ?>
  </body>
</html>
