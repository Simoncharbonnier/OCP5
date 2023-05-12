
# Blog

Ce projet est réalisé dans le cadre de la formation de développeur d'application PHP/Symfony chez OpenClassrooms.

Ce blog doit être réalisé via une architecture MVC.

Voici les différentes technologies utilisées dans ce projet :
- PHP - HTML - CSS- Javascript - Bootstrap - SQL


## Installation

Cloner mon projet

```bash
gh repo clone https://github.com/Simoncharbonnier/OCP5.git
```

Créer une base de données et importer le fichier suivant

```
app/config/db.sql
```

Modifier le fichier ci-dessous avec vos informations

```
app/config/config.php
```

Créer l'hôte virtuel en pointant vers le dossier du blog (OCP5 si vous ne l'avez pas renommé).

Pour accéder au compte administrateur du blog, vous devez utiliser les identifiants suivants :

```
email: simoncharbonnier@orange.fr
password: secret
```

Et tout devrait fonctionner sans soucis !

## Fonctionnalités

- En tant que visiteur, je peux accéder à la page d'accueil.
- En tant que visiteur, je peux utiliser le formulaire de contact.
- En tant que visiteur, je peux accéder à la liste des articles.
- En tant que visiteur, je peux accéder aux détails d'un article.
- En tant que visiteur, je peux accéder au profil d'un utilisateur.
- En tant que visiteur, je peux créer un compte.
- En tant que visiteur, je peux me connecter.

- En tant qu'utilisateur, je peux ajouter un commentaire.
- En tant qu'utilisateur, je peux accéder à mon profil.
- En tant qu'utilisateur, je peux modifier mes informations.
- En tant qu'utilisateur, je peux me déconnecter.

- En tant qu'administrateur, je peux ajouter un article.
- En tant qu'administrateur, je peux modifier un article.
- En tant qu'administrateur, je peux supprimer un article.
- En tant qu'administrateur, je peux accéder à la liste des commentaires.
- En tant qu'administrateur, je peux valider un commentaire.
- En tant qu'administrateur, je peux archiver un commentaire.
- En tant qu'administrateur, je peux supprimer un commentaire.
- En tant qu'administrateur, je peux accéder à la liste des utilisateurs.
- En tant qu'administrateur, je peux supprimer un utilisateur.
