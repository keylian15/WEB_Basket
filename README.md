# NBA Predictor

Une application web pour analyser les performances NBA et obtenir des prédictions intelligentes sur les résultats des matchs.

## Structure du projet MVC

Le projet est structuré selon le modèle MVC (Modèle-Vue-Contrôleur) pour une meilleure organisation du code:

```
project/
├── .env                      # Fichier de configuration avec les informations de la BDD
├── .htaccess                 # Configuration Apache
├── index.php                 # Point d'entrée principal
├── config/
│   └── database.php          # Configuration de la base de données
├── controllers/
│   ├── HomeController.php    # Contrôleur pour la page d'accueil
│   └── AuthController.php    # Contrôleur pour l'authentification (login, register)
├── models/
│   └── User.php              # Modèle pour manipuler les utilisateurs
└── views/
    ├── templates/
    │   ├── header.php        # En-tête de page
    │   └── footer.php        # Pied de page
    ├── home/
    │   └── index.php         # Vue de la page d'accueil
    └── auth/
        ├── login.php         # Vue de la page de connexion
        └── register.php      # Vue de la page d'inscription
```

## Base de données

La base de données contient une table `users` avec la structure suivante:

- `id` (INT) - Identifiant unique
- `password` (VARCHAR(255)) - Mot de passe haché
- `email` (VARCHAR(50)) - Adresse email
- `is_admin` (BOOLEAN) - Statut administrateur

## Installation

1. Clonez ce dépôt
2. Configurez votre serveur web (Apache/Nginx) pour pointer vers le dossier du projet
3. Importez la base de données à partir du fichier SQL fourni
4. Vérifiez que le fichier `.env` contient les bonnes informations de connexion à la base de données
5. Assurez-vous que le serveur web a les droits d'écriture sur le dossier du projet

## Fonctionnalités

- Page d'accueil avec statistiques et matchs à venir
- Système d'authentification (inscription, connexion, déconnexion)
- Affichage des équipes, joueurs et matchs NBA
- Prédictions de résultats de matchs

## Technologie utilisée

- PHP 8.0+
- MySQL
- HTML5/CSS3
- JavaScript
- Bootstrap 5
- PDO pour les connexions à la base de données
- Architecture MVC