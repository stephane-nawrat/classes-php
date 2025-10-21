# classes-php
Création d'une classe et ses méthodes associées.

#  Projet Classes PHP - Gestion d'Utilisateurs
 
> **Formation :** Titre RNCP Développeur Web & Web Mobile  
> **Période :** Octobre 2025 

---

##  Contexte du projet

### Objectif de l'exercice

Créer deux classes PHP (`User` et `UserPDO`) permettant la gestion complète d'utilisateurs avec :
- **MySQLi** pour la classe `User`
- **PDO** pour la classe `UserPDO`

L'objectif est de **comprendre et maîtriser** :
- La Programmation Orientée Objet (POO) en PHP
- Les deux méthodes de connexion à MySQL (MySQLi et PDO)
- La sécurité des applications web (injection SQL, hachage de mots de passe)
- Les bonnes pratiques de développement

### Pourquoi deux classes différentes ?

**Approche pédagogique par comparaison :**
- Apprendre en **codant deux fois** la même logique avec des syntaxes différentes
- Comprendre les **avantages et inconvénients** de chaque méthode
- Pouvoir **choisir en connaissance de cause** pour les futurs projets
- Solidifier la compréhension de la POO par la répétition

**MySQLi vs PDO :**
- **MySQLi** : Spécifique à MySQL, encore très utilisé en entreprise
- **PDO** : Plus moderne, multi-bases de données, recommandé pour nouveaux projets

---

## 📋 Cahier des charges

### Fonctionnalités implémentées

**Système CRUD complet :**
- ✅ **Create** : Inscription d'un nouvel utilisateur (`register()`)
- ✅ **Read** : Connexion et récupération des données (`connect()`, `getAllInfos()`, getters)
- ✅ **Update** : Modification des informations (`update()`)
- ✅ **Delete** : Suppression d'un utilisateur (`delete()`)

**Sécurité :**
- ✅ Requêtes préparées (protection injection SQL)
- ✅ Hachage des mots de passe (bcrypt via `password_hash()`)
- ✅ Validation des données
- ✅ Gestion des erreurs

**Gestion des sessions :**
- ✅ Connexion/Déconnexion (`connect()`, `disconnect()`)
- ✅ Vérification de l'état (`isConnected()`)
- ✅ Persistance des données utilisateur dans l'objet

---

## 🏗️ Architecture du projet
```
classes-php/
├── classes/
│   ├── User.php              # Classe MySQLi (400 lignes)
│   └── UserPDO.php           # Classe PDO (400 lignes)
├── config/
│   └── database.php          # Configuration BDD + chargement .env
├── sql/
│   └── schema.sql            # Structure de la base de données
├── tests/                    # 12 fichiers de test
│   ├── test-integration-user.php
│   ├── test-integration-userpdo.php
│   ├── test-method-*.php
│   └── ...
├── docs/
│   ├── COMPARATIF-MYSQLI-PDO.md
│   └── EXEMPLES-UTILISATION.md
├── .env                      # Credentials (NON versionné)
├── .env.example              # Template de configuration
├── .gitignore
└── README.md
```

---

## 🚀 Installation

### Prérequis

- PHP 8.3+ 
- MySQL 9.4+
- Git
- Serveur web (Apache, nginx) ou `php -S`

### Étapes d'installation
```bash
# 1. Cloner le repository
git clone https://github.com/stephane-nawrat/classes-php.git
cd classes-php

# 2. Créer le fichier .env depuis le template
cp .env.example .env

# 3. Éditer .env avec vos credentials
# DB_HOST=127.0.0.1
# DB_USER=root
# DB_PASS=votre_mot_de_passe
# DB_NAME=phase01_classes

# 4. Créer la base de données
mysql -u root -p < sql/schema.sql

# 5. Tester l'installation
php tests/test-integration-user.php
php tests/test-integration-userpdo.php
```

---

## 💻 Utilisation

### Exemple avec MySQLi
```php
<?php
require_once 'classes/User.php';

// Inscription
$user = new User();
$user->register("alice", "motdepasse123", "alice@mail.com", "Alice", "Dupont");

// Connexion
$user2 = new User();
if ($user2->connect("alice", "motdepasse123")) {
    echo "Bienvenue " . $user2->getFirstname();
    
    // Modification
    $user2->update("alice", "nouveau_pass", "alice@mail.com", "Alice", "Martin");
    
    // Déconnexion
    $user2->disconnect();
}
```

### Exemple avec PDO
```php
<?php
require_once 'classes/UserPDO.php';

// Utilisation identique à MySQLi !
$user = new UserPDO();
$user->register("bob", "password", "bob@mail.com", "Bob", "Martin");
```

➡️ [Voir plus d'exemples](docs/EXEMPLES-UTILISATION.md)

---

## 📊 Méthodes disponibles

| Méthode | Paramètres | Retour | Description |
|---------|------------|--------|-------------|
| `__construct()` | - | void | Connexion automatique à la BDD |
| `register()` | login, password, email, firstname, lastname | array | Créer un utilisateur |
| `connect()` | login, password | bool | Connecter un utilisateur |
| `disconnect()` | - | void | Déconnecter l'utilisateur |
| `delete()` | - | bool | Supprimer l'utilisateur |
| `update()` | login, password, email, firstname, lastname | bool | Modifier les infos |
| `isConnected()` | - | bool | Vérifier si connecté |
| `getAllInfos()` | - | array\|null | Récupérer toutes les infos |
| `getLogin()` | - | string\|null | Récupérer le login |
| `getEmail()` | - | string\|null | Récupérer l'email |
| `getFirstname()` | - | string\|null | Récupérer le prénom |
| `getLastname()` | - | string\|null | Récupérer le nom |

---

## 🔒 Sécurité

### Mesures implémentées

**Protection injection SQL :**
```php
// ❌ DANGEREUX (non fait dans ce projet)
$sql = "SELECT * FROM users WHERE login = '$login'";

// ✅ SÉCURISÉ (requêtes préparées)
$stmt = $conn->prepare("SELECT * FROM users WHERE login = ?");
$stmt->execute([$login]);
```

**Hachage des mots de passe :**
```php
// ❌ DANGEREUX
INSERT INTO users (password) VALUES ('motdepasse123');

// ✅ SÉCURISÉ
$hash = password_hash('motdepasse123', PASSWORD_DEFAULT);
INSERT INTO users (password) VALUES ('$2y$10$...');
```

**Fichiers sensibles non versionnés :**
- `.env` contient les credentials → dans `.gitignore`
- Seul `.env.example` est sur GitHub

---

## 🧪 Tests

### Lancer tous les tests
```bash
# Tests MySQLi
php tests/test-integration-user.php

# Tests PDO
php tests/test-integration-userpdo.php

# Tests individuels
php tests/test-method-register.php
php tests/test-method-connect.php
# etc.
```

### Serveur de développement
```bash
# Lancer le serveur PHP
php -S localhost:8000

# Ouvrir dans le navigateur
http://localhost:8000/tests/test-user-web.php
```

---

## 📚 Documentation complémentaire

- [Comparatif MySQLi vs PDO](docs/COMPARATIF-MYSQLI-PDO.md)
- [Exemples d'utilisation détaillés](docs/EXEMPLES-UTILISATION.md)
- [Guide Git & GitHub](README.md#-guide-git--github-pédagogique)

---

## 🎓 Compétences acquises

### Programmation Orientée Objet
- Classes et objets
- Attributs (public/private)
- Méthodes et constructeur
- Encapsulation
- `$this` (référence à soi-même)

### Bases de données
- Connexion MySQLi et PDO
- Requêtes SQL (INSERT, SELECT, UPDATE, DELETE)
- Requêtes préparées
- Gestion des résultats

### Sécurité
- Protection injection SQL
- Hachage de mots de passe (bcrypt)
- Variables d'environnement
- Validation des données

### Outils & Workflow
- Git (branches, commits, merge)
- GitHub
- Tests unitaires
- Documentation

---

## 📈 Statistiques du projet

- **Lignes de code PHP :** ~1500
- **Commits Git :** 35+
- **Branches utilisées :** 5
- **Fichiers de test :** 12
- **Durée du projet :** 3 jours
- **Méthodes codées :** 24 (12 par classe)

---

## 👤 Auteur

**Stéphane Nawrat**  
Étudiant - Développeur Web & Web Mobile  
[GitHub](https://github.com/stephane-nawrat)

---

## 📝 Licence

Projet pédagogique - Formation La Plateforme_  
Octobre 2025

---

## 🙏 Remerciements

- **La Plateforme_** pour la formation
- **Claude (Anthropic)** pour l'assistance pédagogique
- **La communauté PHP** pour la documentation

---

*Dernière mise à jour : 21 octobre 2025*

## 📚 Guide Git & GitHub (Pédagogique)

### Structure des branches

Ce projet utilise une stratégie de branches par fonctionnalité :
```
main (code stable)
  │
  ├── feat/database       → Création BDD + tables
  ├── feat/config         → Configuration + .env
  ├── feat/user-mysqli    → Classe User (MySQLi)
  ├── feat/user-pdo       → Classe UserPDO (PDO)
  └── docs/final          → Documentation finale
```

### Workflow type

#### 1. Créer une nouvelle branche
```bash
# Créer et basculer sur une nouvelle branche
git checkout -b feat/ma-fonctionnalite

# Vérifier sur quelle branche on est
git branch
```

#### 2. Travailler et commiter
```bash
# Voir les fichiers modifiés
git status

# Ajouter les fichiers
git add .                    # Tous les fichiers
git add fichier.php          # Un fichier spécifique

# Commiter avec un message clair
git commit -m "feat(scope): description courte

- Détail 1
- Détail 2"

# Push vers GitHub (premier push)
git push -u origin feat/ma-fonctionnalite

# Push suivants (si tracking configuré)
git push
```

#### 3. Merger dans main
```bash
# Retour sur main
git checkout main

# Récupérer les dernières modifications
git pull origin main

# Merger la branche de fonctionnalité
git merge feat/ma-fonctionnalite

# Push main
git push origin main
```

#### 4. Nettoyer les branches (optionnel)
```bash
# Supprimer la branche locale (après merge)
git branch -d feat/ma-fonctionnalite

# Supprimer la branche distante
git push origin --delete feat/ma-fonctionnalite
```

---

### Convention de messages de commit

Format recommandé : **Conventional Commits**
```
<type>(<scope>): <description>

[corps optionnel]
```

**Types courants :**
- `feat` : Nouvelle fonctionnalité
- `fix` : Correction de bug
- `docs` : Documentation
- `test` : Ajout/modification de tests
- `refactor` : Refactorisation de code
- `style` : Formatage (pas de changement de logique)

**Exemples :**
```bash
git commit -m "feat(database): create users table"
git commit -m "fix(auth): resolve password hashing issue"
git commit -m "docs(readme): add git workflow section"
git commit -m "test(user): add connection test"
```

---

### Commandes utiles
```bash
# Voir l'historique des commits
git log --oneline --graph --all

# Voir les différences avant commit
git diff

# Annuler les modifications non commitées
git checkout -- fichier.php

# Voir les branches locales
git branch

# Voir toutes les branches (locales + distantes)
git branch -a

# Changer de branche
git checkout nom-branche

# Voir le statut détaillé
git status
```

---

### Configuration recommandée
```bash
# Votre identité (à faire une seule fois)
git config --global user.name "Votre Nom"
git config --global user.email "votre@email.com"

# Push simplifié (juste "git push")
git config --global push.default current
git config --global push.autoSetupRemote true

# Éditeur par défaut (VSCode)
git config --global core.editor "code --wait"

# Couleurs dans le terminal
git config --global color.ui auto
```

---

### Résolution de problèmes courants

#### Erreur : "non-fast-forward"
```bash
# Récupérer les modifications distantes d'abord
git pull origin main
git push origin main
```

#### Oublié de créer une branche
```bash
# Créer une branche avec les modifications actuelles
git checkout -b feat/nouvelle-branche
```

#### Commit sur la mauvaise branche
```bash
# Annuler le dernier commit (garde les modifications)
git reset --soft HEAD~1

# Changer de branche
git checkout bonne-branche

# Re-commiter
git add .
git commit -m "message"
```

---

### Ressources

- [Documentation Git officielle](https://git-scm.com/doc)
- [Conventional Commits](https://www.conventionalcommits.org/)
- [GitHub Guides](https://guides.github.com/)
