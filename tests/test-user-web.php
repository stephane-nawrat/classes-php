<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Test User - Web</title>
    <style>
        body {
            font-family: monospace;
            padding: 20px;
            background: #1e1e1e;
            color: #d4d4d4;
        }

        .success {
            color: #4ec9b0;
        }

        .info {
            color: #9cdcfe;
        }

        h1 {
            color: #569cd6;
        }
    </style>
</head>

<body>
    <h1>=== TEST CLASSE USER (Web) ===</h1>

    <?php
    // Inclusion de la classe
    require_once __DIR__ . '/../classes/User.php';

    echo "<p class='info'>Création d'un objet User...</p>";
    $user = new User();
    echo "<p class='success'>✅ Objet créé !</p>";

    // Modifier les attributs
    $user->login = "alice";
    $user->email = "alice@exemple.com";
    $user->firstname = "Alice";
    $user->lastname = "Dupont";

    echo "<h2>Informations de l'utilisateur :</h2>";
    echo "<ul>";
    echo "<li>Login: " . $user->login . "</li>";
    echo "<li>Email: " . $user->email . "</li>";
    echo "<li>Prénom: " . $user->firstname . "</li>";
    echo "<li>Nom: " . $user->lastname . "</li>";
    echo "</ul>";

    echo "<p class='success'>✅ Test terminé !</p>";
    ?>
</body>

</html>