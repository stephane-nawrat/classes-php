<?php

/**
 * Test de la méthode connect()
 */

require_once __DIR__ . '/../classes/User.php';

echo "=== TEST MÉTHODE connect() ===\n\n";

// Test 1 : Connexion RÉUSSIE
echo "--- Test 1 : Connexion avec bon login et bon password ---\n";
$user1 = new User();
$result = $user1->connect("alice", "motdepasse123");

if ($result) {
    echo "✅ Connexion réussie !\n";
    echo "  ID: {$user1->login}\n";
    echo "  Email: {$user1->email}\n";
    echo "  Prénom: {$user1->firstname}\n";
    echo "  Nom: {$user1->lastname}\n";
} else {
    echo "❌ Connexion échouée\n";
}

echo "\n";

// Test 2 : Mauvais mot de passe
echo "--- Test 2 : Connexion avec bon login MAIS mauvais password ---\n";
$user2 = new User();
$result = $user2->connect("alice", "MAUVAIS_PASSWORD");

if ($result) {
    echo "❌ ERREUR : Connexion réussie alors qu'elle devrait échouer !\n";
} else {
    echo "✅ Connexion refusée (normal)\n";
}

echo "\n";

// Test 3 : Login inexistant
echo "--- Test 3 : Connexion avec login inexistant ---\n";
$user3 = new User();
$result = $user3->connect("bob", "motdepasse123");

if ($result) {
    echo "❌ ERREUR : Connexion réussie alors que l'user n'existe pas !\n";
} else {
    echo "✅ Connexion refusée (normal)\n";
}

echo "\n✅ Tous les tests terminés !\n";
