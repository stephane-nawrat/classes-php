<?php

/**
 * Test de la méthode register()
 */

require_once __DIR__ . '/../classes/User.php';

echo "=== TEST MÉTHODE register() ===\n\n";

// Création d'un objet User
$user = new User();

// Inscription d'un nouvel utilisateur
echo "Inscription d'Alice...\n";
$result = $user->register(
    "alice",                    // login
    "motdepasse123",           // password (sera haché)
    "alice@exemple.com",       // email
    "Alice",                   // firstname
    "Dupont"                   // lastname
);

echo "✅ Utilisateur créé !\n\n";

// Affichage du résultat
echo "Informations retournées :\n";
print_r($result);

echo "\nAttributs de l'objet \$user :\n";
echo "  ID: " . $result['id'] . "\n";
echo "  Login: " . $result['login'] . "\n";
echo "  Email: " . $result['email'] . "\n";
echo "  Prénom: " . $result['firstname'] . "\n";
echo "  Nom: " . $result['lastname'] . "\n";

echo "\n✅ Test terminé !\n";
