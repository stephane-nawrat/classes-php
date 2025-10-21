<?php

/**
 * Test basique de la classe User
 */

// Inclusion de la classe
require_once __DIR__ . '/../classes/User.php';

echo "=== TEST CLASSE USER ===\n\n";

// Créer un nouvel utilisateur
echo "Création d'un objet User...\n";
$user = new User();
echo "✅ Objet créé !\n\n";

// Modifier les attributs publics
$user->login = "alice";
$user->email = "alice@exemple.com";
$user->firstname = "Alice";
$user->lastname = "Dupont";

// Afficher
echo "Informations de l'utilisateur :\n";
echo "  Login: " . $user->login . "\n";
echo "  Email: " . $user->email . "\n";
echo "  Prénom: " . $user->firstname . "\n";
echo "  Nom: " . $user->lastname . "\n\n";

// Tester l'attribut privé
echo "Test de l'attribut privé \$id :\n";
// Décommente la ligne suivante pour voir l'erreur :
// $user->id = 5;
echo "  (On ne peut pas accéder à \$id depuis l'extérieur)\n";

echo "\n✅ Test terminé !\n";
