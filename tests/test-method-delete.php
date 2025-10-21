<?php

/**
 * Test de la méthode delete()
 */

require_once __DIR__ . '/../classes/User.php';

echo "=== TEST MÉTHODE delete() ===\n\n";

// Test 1 : Essayer de supprimer SANS être connecté
echo "--- Test 1 : Suppression sans connexion ---\n";
$user1 = new User();
$result = $user1->delete();

if ($result) {
    echo "❌ ERREUR : Suppression réussie sans être connecté !\n";
} else {
    echo "✅ Suppression refusée (normal, pas connecté)\n";
}

echo "\n";

// Test 2 : Créer un user de test, puis le supprimer
echo "--- Test 2 : Création puis suppression ---\n";
$user2 = new User();

// Créer un user temporaire
echo "Création de 'bob_test'...\n";
$user2->register("bob_test", "password123", "bob@test.com", "Bob", "Test");
echo "✅ User créé avec ID: " . $user2->login . "\n\n";

echo "Suppression de 'bob_test'...\n";
$result = $user2->delete();

if ($result) {
    echo "✅ Suppression réussie !\n";
    echo "Vérification de la déconnexion :\n";
    echo "  Login: " . ($user2->login ?? "[NULL]") . "\n";
    echo "  Email: " . ($user2->email ?? "[NULL]") . "\n";
} else {
    echo "❌ ERREUR : Suppression échouée\n";
}

echo "\n";

// Test 3 : Vérifier que le user n'existe plus en BDD
echo "--- Test 3 : Vérification en BDD ---\n";
$user3 = new User();
$exists = $user3->connect("bob_test", "password123");

if ($exists) {
    echo "❌ ERREUR : Le user existe encore en BDD !\n";
} else {
    echo "✅ Le user n'existe plus en BDD (supprimé)\n";
}

echo "\n✅ Tous les tests terminés !\n";
