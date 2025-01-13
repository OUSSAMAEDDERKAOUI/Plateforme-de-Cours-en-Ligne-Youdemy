# Youdemy - Plateforme de Cours en Ligne

## Contexte du projet
Youdemy est une plateforme de cours en ligne visant à révolutionner l'apprentissage en ligne. Elle permet aux étudiants et enseignants d'interagir via un système de gestion des cours, avec des fonctionnalités adaptées à chaque rôle (étudiant ou enseignant). Le site propose un catalogue de cours, un système d'inscription et une gestion de contenu pour les enseignants.

## Fonctionnalités

### Front Office

#### Pour les Visiteurs
- Accès au catalogue des cours avec pagination.
- Recherche de cours par mots-clés.
- Création d’un compte avec le choix du rôle (Étudiant ou Enseignant).

#### Pour les Étudiants
- Visualisation du catalogue des cours.
- Recherche et consultation des détails des cours (description, contenu, enseignant, etc.).
- Inscription à un cours après authentification.
- Accès à une section "Mes cours" regroupant les cours rejoints.

#### Pour les Enseignants
- Ajout de nouveaux cours (Titre, description, contenu, tags, catégorie).
- Gestion des cours (Modification, suppression, consultation des inscriptions).
- Accès à une section "Statistiques" sur les cours (Nombre d’étudiants inscrits, Nombre de cours, etc.).

### Back Office

#### Pour les Administrateurs
- Validation des comptes enseignants.
- Gestion des utilisateurs (activation, suspension, suppression).
- Gestion des contenus (cours, catégories, tags).
- Insertion en masse de tags.
- Accès à des statistiques globales (Nombre total de cours, répartition par catégorie, cours avec le plus d’étudiants, Top 3 enseignants).

### Fonctionnalités Transversales
- Relation **many-to-many** pour l’association des cours et des tags.
- Application du **polymorphisme** pour les méthodes `Ajouter cours` et `Afficher cours`.
- Système d'**authentification et d’autorisation**.
- **Contrôle d’accès** basé sur le rôle de l’utilisateur (Étudiant, Enseignant, Administrateur).

## Exigences Techniques
- Utilisation des principes de **Programmation Orientée Objet (OOP)** : Encapsulation, héritage, polymorphisme.
- Base de données relationnelle avec gestion des relations **one-to-many** et **many-to-many**.
- Gestion des sessions PHP pour la gestion des utilisateurs connectés.
- Validation des données côté serveur pour garantir la sécurité (protection contre XSS, CSRF et injection SQL).

## Bonus (Fonctionnalités Optionnelles)
- **Recherche avancée** avec filtres (catégorie, tags, auteur).
- **Statistiques avancées** : Taux d’engagement par cours, catégories populaires.
- **Système de notifications** : Validation de compte enseignant, inscription confirmée.
- **Commentaires ou évaluations** sur les cours.
- **Génération de certificats PDF** de complétion pour les étudiants.

## Technologies Utilisées
- **PHP** pour la logique backend.
- **MySQL** pour la gestion de la base de données.
- **HTML5, CSS3, JavaScript (Natif)** pour la partie front-end.
- **Bootstrap** pour la mise en page responsive.
- **Sessions PHP** pour la gestion de l'authentification et des utilisateurs.

## Installation

### Prérequis
1. Serveur local (ex : XAMPP, WAMP, ou LAMP).
2. Serveur de base de données MySQL.

### Étapes d'installation
1. Clonez ce repository :
   ```bash
   git clone https://github.com/OUSSAMAEDDERKAOUI/Plateforme-de-Cours-en-Ligne-Youdemy.git
