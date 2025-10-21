# 💻 Exemples d'utilisation

> Guide pratique avec cas d'usage réels des classes User et UserPDO

---

## 🎯 Cas d'usage courants

### 1. Inscription d'un nouvel utilisateur
```php
<?php
require_once 'classes/User.php'; // ou UserPDO.php

$user = new User();

// Inscription
$result = $user->register(
    "alice",
    "MotD3P@sse!Fort",
    "alice@exemple.com",
    "Alice",
    "Dupont"
);

// Affichage
echo "Bienvenue {$result['firstname']} !";
echo "Votre ID est : {$result['id']}";
```

**Résultat :**
```
Bienvenue Alice !
Votre ID est : 1
```

---

### 2. Connexion utilisateur
```php
<?php
require_once 'classes/User.php';

$user = new User();

if ($user->connect("alice", "MotD3P@sse!Fort")) {
    echo "Connexion réussie !";
    echo "Email : " . $user->getEmail();
} else {
    echo "Login ou mot de passe incorrect.";
}
```

---

### 3. Vérifier si un utilisateur est connecté
```php
<?php
$user = new User();
$user->connect("alice", "password");

if ($user->isConnected()) {
    echo "Bonjour " . $user->getFirstname();
} else {
    echo "Veuillez vous connecter";
}
```

---

### 4. Modifier les informations
```php
<?php
$user = new User();
$user->connect("alice", "ancien_password");

// Modification
$success = $user->update(
    "alice_updated",
    "nouveau_password",
    "alice.new@exemple.com",
    "Alice-Marie",
    "Dupont-Martin"
);

if ($success) {
    echo "Profil mis à jour !";
}
```

---

### 5. Supprimer un compte
```php
<?php
$user = new User();
$user->connect("alice", "password");

if ($user->delete()) {
    echo "Compte supprimé avec succès.";
    // $user est maintenant déconnecté automatiquement
}
```

---

## 🔐 Formulaire d'inscription complet

### HTML
```html
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Créer un compte</h1>
    <form method="POST" action="traitement_inscription.php">
        <input type="text" name="login" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="firstname" placeholder="Prénom" required>
        <input type="text" name="lastname" placeholder="Nom" required>
        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
```

### PHP (traitement_inscription.php)
```php
<?php
require_once 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    
    // Validation basique
    if (empty($login) || empty($password) || empty($email)) {
        die("Tous les champs sont obligatoires");
    }
    
    // Inscription
    $user = new User();
    try {
        $result = $user->register($login, $password, $email, $firstname, $lastname);
        
        echo "Compte créé avec succès !";
        echo "Bienvenue {$result['firstname']} {$result['lastname']}";
        
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
```

---

## 🔑 Formulaire de connexion

### HTML
```html
<form method="POST" action="traitement_connexion.php">
    <input type="text" name="login" placeholder="Nom d'utilisateur" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
</form>
```

### PHP (traitement_connexion.php)
```php
<?php
session_start();
require_once 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = $_POST['password'];
    
    $user = new User();
    
    if ($user->connect($login, $password)) {
        // Stocker les infos en session
        $_SESSION['user_id'] = $user->getAllInfos()['id'];
        $_SESSION['user_login'] = $user->getLogin();
        
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Identifiants incorrects";
    }
}
```

---

## 👤 Page de profil
```php
<?php
session_start();
require_once 'classes/User.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_login'])) {
    header('Location: connexion.php');
    exit;
}

$user = new User();
$user->connect($_SESSION['user_login'], ""); // Reconnexion fictive ou via session

$infos = $user->getAllInfos();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
</head>
<body>
    <h1>Mon Profil</h1>
    <p><strong>Login :</strong> <?= htmlspecialchars($infos['login']) ?></p>
    <p><strong>Email :</strong> <?= htmlspecialchars($infos['email']) ?></p>
    <p><strong>Nom complet :</strong> 
        <?= htmlspecialchars($infos['firstname']) ?> 
        <?= htmlspecialchars($infos['lastname']) ?>
    </p>
    
    <a href="modifier_profil.php">Modifier</a>
    <a href="deconnexion.php">Déconnexion</a>
</body>
</html>
```

---

## 🚪 Déconnexion
```php
<?php
// deconnexion.php
session_start();
session_destroy();

header('Location: index.php');
exit;
```

---

## ⚙️ Utilisation avancée

### Vérifier si un login existe déjà
```php
<?php
$user = new User();

// Tentative de connexion avec un faux mot de passe
if (!$user->connect("alice", "fake_password_to_check")) {
    // Si ça échoue, on ne sait pas si c'est le login ou le password
    // Pour des raisons de sécurité, c'est voulu !
}

// Alternative : créer une méthode loginExists() (exercice)
```

### Changer uniquement le mot de passe
```php
<?php
$user = new User();
$user->connect("alice", "ancien_password");

// Récupérer les infos actuelles
$infos = $user->getAllInfos();

// Mettre à jour SEULEMENT le password
$user->update(
    $infos['login'],
    "nouveau_password",  // Nouveau
    $infos['email'],
    $infos['firstname'],
    $infos['lastname']
);
```

---

## 🔄 Comparaison MySQLi vs PDO (même logique)

### Avec MySQLi
```php
<?php
require_once 'classes/User.php';

$user = new User();
$user->register("alice", "pass", "alice@mail.com", "Alice", "Dupont");
```

### Avec PDO (syntaxe identique !)
```php
<?php
require_once 'classes/UserPDO.php';

$user = new UserPDO();
$user->register("alice", "pass", "alice@mail.com", "Alice", "Dupont");
```

**L'utilisation est IDENTIQUE !** Seul le nom de la classe change.

---

## 🎓 Exercices suggérés

### Niveau 1 : Débutant
1. Créer une page d'inscription fonctionnelle
2. Créer une page de connexion
3. Afficher le profil de l'utilisateur connecté

### Niveau 2 : Intermédiaire
1. Ajouter une validation email (format)
2. Ajouter une validation mot de passe (longueur min)
3. Créer une page de modification de profil

### Niveau 3 : Avancé
1. Ajouter une méthode `emailExists()` 
2. Système de réinitialisation de mot de passe
3. Upload de photo de profil
4. Gestion des rôles (admin, user, etc.)

---

## 📚 Ressources complémentaires

- [Documentation PHP - POO](https://www.php.net/manual/fr/language.oop5.php)
- [Documentation PHP - MySQLi](https://www.php.net/manual/fr/book.mysqli.php)
- [Documentation PHP - PDO](https://www.php.net/manual/fr/book.pdo.php)
- [OWASP - Sécurité PHP](https://owasp.org/www-project-php-security/)

---

*Document mis à jour : 21 octobre 2025*