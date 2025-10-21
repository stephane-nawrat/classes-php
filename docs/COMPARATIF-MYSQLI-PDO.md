# 🔄 Comparatif MySQLi vs PDO

> Guide pédagogique pour comprendre les différences entre les deux méthodes de connexion MySQL en PHP

---

## 🎯 Vue d'ensemble

| Critère | MySQLi | PDO |
|---------|--------|-----|
| **Bases supportées** | MySQL uniquement | MySQL, PostgreSQL, SQLite, Oracle, etc. |
| **Style de code** | Procédural OU Orienté Objet | Orienté Objet uniquement |
| **Performance** | Légèrement plus rapide | Performances équivalentes |
| **Facilité d'utilisation** | Syntaxe plus verbeuse | Syntaxe plus concise |
| **Portabilité** | Spécifique MySQL | Multi-bases (portable) |
| **Gestion erreurs** | Manuelle | Exceptions natives |
| **Recommandation 2025** | ✅ OK (legacy) | ✅✅ **Préféré** |

---

## 📊 Comparaison syntaxique

### 1. Connexion à la base

#### MySQLi
```php
$conn = mysqli_connect(
    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME,
    DB_PORT
);

if (!$conn) {
    die("Erreur : " . mysqli_connect_error());
}

mysqli_set_charset($conn, DB_CHARSET);
```

#### PDO
```php
try {
    $dsn = "mysql:host=" . DB_HOST . 
           ";dbname=" . DB_NAME . 
           ";port=" . DB_PORT . 
           ";charset=" . DB_CHARSET;
    
    $conn = new PDO($dsn, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
```

**🔑 Différences clés :**
- MySQLi : fonction `mysqli_connect()`
- PDO : instanciation d'objet `new PDO()`
- PDO : DSN (Data Source Name) unique pour tous les paramètres
- PDO : Gestion native des exceptions

---

### 2. Requêtes préparées

#### MySQLi
```php
// Préparation
$sql = "INSERT INTO users (login, email) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);

// Binding (spécifier les types)
mysqli_stmt_bind_param($stmt, "ss", $login, $email);
//                              ^^
//                              s = string, i = integer, d = double

// Exécution
mysqli_stmt_execute($stmt);

// Récupération de l'ID
$id = mysqli_insert_id($conn);

// Fermeture
mysqli_stmt_close($stmt);
```

#### PDO
```php
// Préparation
$sql = "INSERT INTO users (login, email) VALUES (:login, :email)";
$stmt = $conn->prepare($sql);

// Exécution directe avec les valeurs
$stmt->execute([
    ':login' => $login,
    ':email' => $email
]);

// Récupération de l'ID
$id = $conn->lastInsertId();

// Pas besoin de fermer (automatique)
```

**🔑 Différences clés :**
- MySQLi : `?` comme placeholder + `bind_param()` avec types
- PDO : `:nom` comme placeholder + `execute([...])` direct
- PDO : Pas besoin de spécifier les types (auto-détection)
- PDO : Pas besoin de fermer le statement

---

### 3. SELECT avec résultats

#### MySQLi
```php
// Préparation
$sql = "SELECT id, login, email FROM users WHERE login = ?";
$stmt = mysqli_prepare($conn, $sql);

// Binding paramètre
mysqli_stmt_bind_param($stmt, "s", $login);

// Exécution
mysqli_stmt_execute($stmt);

// Binding résultat
mysqli_stmt_bind_result($stmt, $id, $dbLogin, $email);

// Récupération
if (mysqli_stmt_fetch($stmt)) {
    // $id, $dbLogin, $email sont remplis
    echo "ID: $id, Login: $dbLogin";
}

mysqli_stmt_close($stmt);
```

#### PDO
```php
// Préparation
$sql = "SELECT id, login, email FROM users WHERE login = :login";
$stmt = $conn->prepare($sql);

// Exécution
$stmt->execute([':login' => $login]);

// Récupération (tableau associatif)
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "ID: {$user['id']}, Login: {$user['login']}";
}
```

**🔑 Différences clés :**
- MySQLi : `bind_result()` obligatoire, variables séparées
- PDO : `fetch()` direct, retourne un tableau associatif
- PDO : Plus simple et plus lisible

---

## 💡 Quand utiliser quoi ?

### Utilisez MySQLi si :
- ✅ Vous travaillez UNIQUEMENT avec MySQL
- ✅ Vous maintenez un projet legacy existant
- ✅ Vous avez une équipe habituée à MySQLi
- ✅ Performances critiques (différence négligeable en réalité)

### Utilisez PDO si :
- ✅✅ Vous démarrez un nouveau projet
- ✅✅ Vous voulez la portabilité multi-bases
- ✅✅ Vous préférez une syntaxe moderne et concise
- ✅✅ Vous voulez les exceptions natives
- ✅✅ **Recommandation 2025**

---

## 🎓 Pourquoi apprendre les deux ?

### Raisons pédagogiques
1. **Comprendre les concepts** : En codant deux fois, on solidifie la compréhension
2. **Polyvalence** : Pouvoir travailler sur n'importe quel projet
3. **Vision globale** : Comprendre qu'il existe plusieurs approches
4. **Capacité de choix** : Décider en connaissance de cause

### Raisons professionnelles
1. **Marché du travail** : MySQLi encore présent dans beaucoup d'entreprises
2. **Maintenance** : Pouvoir reprendre du code existant
3. **Migration** : Savoir passer de MySQLi à PDO
4. **Compétence complète** : Montrer sa maîtrise des deux méthodes

---

## 📈 Évolution et tendances

**Historique :**
- **MySQL Extension** (obsolète depuis PHP 5.5, supprimée en PHP 7.0)
- **MySQLi** (introduite en PHP 5.0, toujours maintenue)
- **PDO** (introduite en PHP 5.1, **recommandée depuis PHP 5.3**)

**Tendance actuelle (2025) :**
- 🔴 MySQL Extension : **SUPPRIMÉE**
- 🟡 MySQLi : Maintenue mais en déclin
- 🟢 PDO : **Standard recommandé**

**Conseil :** Apprenez les deux, mais **privilégiez PDO** pour vos nouveaux projets.

---

## 🔒 Sécurité

### Les deux sont sécurisés SI bien utilisés

**Requêtes préparées obligatoires :**
```php
// ❌ DANGEREUX (les deux)
$sql = "SELECT * FROM users WHERE login = '$login'"; // Injection SQL !

// ✅ SÉCURISÉ (MySQLi)
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE login = ?");
mysqli_stmt_bind_param($stmt, "s", $login);

// ✅ SÉCURISÉ (PDO)
$stmt = $conn->prepare("SELECT * FROM users WHERE login = :login");
$stmt->execute([':login' => $login]);
```

**Gestion des erreurs :**
- MySQLi : Affiche les erreurs par défaut (risque de fuite d'infos)
- PDO : Mode exception recommandé (meilleur contrôle)

---

## 📝 Résumé

| Aspect | Gagnant |
|--------|---------|
| Simplicité syntaxe | 🏆 PDO |
| Portabilité | 🏆 PDO |
| Performance | 🤝 Égalité |
| Gestion erreurs | 🏆 PDO |
| Communauté | 🏆 PDO |
| Legacy support | 🏆 MySQLi |

**Verdict 2025 :** **PDO est le choix recommandé** pour tout nouveau projet, mais connaître MySQLi reste un atout professionnel.

---

*Document mis à jour : 21 octobre 2025*